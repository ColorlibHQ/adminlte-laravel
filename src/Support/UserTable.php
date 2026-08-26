<?php

namespace ColorlibHQ\AdminLte\Support;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Resolves the database table backing the app's users.
 *
 * Laravel apps are free to rename `users`, and plenty do. Package code that
 * queries it — and stubs that are published into the app — have to point at the
 * real table, so both ask here rather than hardcoding the default name.
 */
class UserTable
{
    /**
     * The table backing the app's users.
     *
     * An authenticated Eloquent user answers for itself, which is the most
     * accurate source and covers multi-model guards. Everything else falls back
     * to the default guard's provider config: `table` for the `database` driver
     * (its GenericUser has no table of its own), otherwise the `model` it names.
     */
    public static function name(?Authenticatable $user = null): string
    {
        if ($user instanceof Model) {
            return $user->getTable();
        }

        $table = self::providerConfig('table');

        if (is_string($table) && $table !== '') {
            return $table;
        }

        return self::providerModel()?->getTable() ?? 'users';
    }

    /**
     * The Eloquent model the default guard's provider is pointed at, if it names
     * one that actually resolves.
     */
    private static function providerModel(): ?Model
    {
        $model = self::providerConfig('model');

        if (! is_string($model) || ! class_exists($model)) {
            return null;
        }

        $instance = new $model;

        return $instance instanceof Model ? $instance : null;
    }

    private static function providerConfig(string $key): mixed
    {
        $guard = config('auth.defaults.guard');
        $provider = is_string($guard) ? config("auth.guards.{$guard}.provider") : null;

        return is_string($provider) ? config("auth.providers.{$provider}.{$key}") : null;
    }
}
