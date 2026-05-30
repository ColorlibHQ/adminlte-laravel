<?php

namespace ColorlibHQ\AdminLte\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Writes rows into the scaffolded `activity_log` table. Used by both the
 * package's auth-event listeners (login / logout / failed login) and the
 * published LogsActivity model trait. No-ops gracefully when the table doesn't
 * exist, so it's always safe to call.
 */
class ActivityLogger
{
    private static ?bool $hasTable = null;

    /**
     * @param  array<string, mixed>  $properties
     */
    public static function log(
        string $event,
        ?string $description = null,
        array $properties = [],
        ?Model $subject = null,
        ?int $causerId = null,
    ): void {
        if (! self::hasTable()) {
            return;
        }

        $request = request();

        DB::table('activity_log')->insert([
            'user_id' => $causerId ?? Auth::id(),
            'event' => $event,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties === [] ? null : json_encode($properties),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'created_at' => now(),
        ]);
    }

    /**
     * Reset the memoized table check (useful between tests).
     */
    public static function flushTableCache(): void
    {
        self::$hasTable = null;
    }

    private static function hasTable(): bool
    {
        if (self::$hasTable === null) {
            try {
                self::$hasTable = Schema::hasTable('activity_log');
            } catch (\Throwable) {
                self::$hasTable = false;
            }
        }

        return self::$hasTable;
    }
}
