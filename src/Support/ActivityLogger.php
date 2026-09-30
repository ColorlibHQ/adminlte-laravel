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
 *
 * Properties are passed through redact() before they are stored, so credentials
 * and other secrets never reach the log — even when the published LogsActivity
 * trait records every changed attribute of a model such as User.
 */
class ActivityLogger
{
    /**
     * Property keys matching this pattern are never stored (case-insensitive):
     * passwords and their hashes, remember/API/access/refresh tokens, 2FA secrets
     * and recovery codes, client secrets, API and private keys.
     */
    public const REDACTED_KEY_PATTERN = '/password|secret|token|api_?key|private_?key|recovery_?codes/i';

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
        $properties = self::redact($properties, $subject?->getHidden() ?? []);

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
     * Remove secrets from activity properties: keys matching REDACTED_KEY_PATTERN
     * (at any depth), the subject model's $hidden attributes (top level) and any
     * extra keys listed in config('adminlte.activity_log.redact').
     *
     * @param  array<array-key, mixed>  $properties
     * @param  array<int, string>  $hiddenKeys
     * @return array<array-key, mixed>
     */
    public static function redact(array $properties, array $hiddenKeys = []): array
    {
        $extra = array_filter((array) config('adminlte.activity_log.redact', []), 'is_string');
        $drop = array_flip(array_merge($hiddenKeys, array_values($extra)));

        $clean = [];
        foreach ($properties as $key => $value) {
            if (is_string($key) && (isset($drop[$key]) || preg_match(self::REDACTED_KEY_PATTERN, $key) === 1)) {
                continue;
            }

            $clean[$key] = is_array($value) ? self::redact($value) : $value;
        }

        return $clean;
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
