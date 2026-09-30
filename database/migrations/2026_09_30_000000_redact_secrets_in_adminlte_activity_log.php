<?php

use ColorlibHQ\AdminLte\Support\ActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Up to 1.6.1 the published LogsActivity trait stored every changed attribute of a
 * model in `activity_log.properties` — including password hashes, remember tokens
 * and 2FA secrets when it was added to the User model. 1.6.2 redacts them in
 * ActivityLogger::log(); this migration removes the values already stored.
 *
 * Runs only against the table `adminlte:scaffold activity-log` creates (user_id +
 * ip_address + properties columns), never against spatie/laravel-activitylog's
 * table of the same name. Only the secret keys are removed; the rest of each row
 * is kept.
 */
return new class extends Migration
{
    /** LIKE needles that pre-select rows which may hold a redacted key. */
    private const NEEDLES = ['password', 'secret', 'token', 'key', 'recovery'];

    public function up(): void
    {
        if (! Schema::hasTable('activity_log')
            || ! Schema::hasColumns('activity_log', ['user_id', 'ip_address', 'properties'])
            || Schema::hasColumn('activity_log', 'causer_id')) {
            return;
        }

        // PostgreSQL has no LIKE operator for json columns, so compare its text form there.
        $column = DB::getDriverName() === 'pgsql' ? 'properties::text' : 'properties';

        DB::table('activity_log')
            ->select(['id', 'subject_type', 'properties'])
            ->whereNotNull('properties')
            ->where(function ($query) use ($column) {
                foreach (self::NEEDLES as $needle) {
                    $query->orWhereRaw('lower('.$column.') like ?', ['%'.$needle.'%']);
                }
            })
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                foreach ($rows as $row) {
                    $properties = json_decode((string) $row->properties, true);
                    if (! is_array($properties)) {
                        continue;
                    }

                    $clean = ActivityLogger::redact($properties, $this->hiddenKeys($row->subject_type));
                    if ($clean === $properties) {
                        continue;
                    }

                    DB::table('activity_log')->where('id', $row->id)->update([
                        'properties' => $clean === [] ? null : json_encode($clean),
                    ]);
                }
            });
    }

    public function down(): void
    {
        // Removed secret values cannot (and should not) be restored.
    }

    /**
     * The subject model's $hidden attributes, when its class still exists.
     *
     * @return array<int, string>
     */
    private function hiddenKeys(?string $subjectType): array
    {
        $class = $subjectType ? (Relation::getMorphedModel($subjectType) ?? $subjectType) : null;

        return $class && class_exists($class) && is_subclass_of($class, Model::class)
            ? (new $class)->getHidden()
            : [];
    }
};
