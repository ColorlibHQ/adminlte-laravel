<?php

namespace ColorlibHQ\AdminLte\Console\Concerns;

use ColorlibHQ\AdminLte\Support\UserTable;
use Illuminate\Support\Str;

/**
 * Shared placeholder substitution for the stubs the console commands publish.
 *
 * The published code lands in the consuming app and is read and edited there, so
 * it is written out with real names baked in rather than resolving anything at
 * run time — a migration that consults config is far harder to reason about than
 * one that names its table.
 *
 * Two of the placeholders depend on where the stub itself lives, so substitution
 * reads the stub's own namespace. That keeps an app on the conventional
 * `App\Models\User` getting byte-for-byte what it always got, while an app that
 * put its user model somewhere else gets code that names it.
 */
trait RendersStubs
{
    /**
     * @return array<string, string>
     */
    protected function stubReplacements(string $contents = ''): array
    {
        $model = UserTable::modelClass();

        return [
            '{{ users_model_import }}' => self::userModelImport($model),
            '{{ users_model_ref }}' => self::userModelRef($model, self::namespaceOf($contents)),
            '{{ users_table }}' => UserTable::name(),
        ];
    }

    protected function renderStub(string $stubPath): string
    {
        $contents = (string) file_get_contents($stubPath);

        return strtr($contents, $this->stubReplacements($contents));
    }

    /**
     * What goes after `use` so the rest of the file can say `User`. A model whose
     * short name is already `User` needs no alias — and most are.
     */
    private static function userModelImport(string $model): string
    {
        return Str::afterLast($model, '\\') === 'User' ? $model : $model.' as User';
    }

    /**
     * How a file in $namespace has to spell the model inline. Same namespace and
     * the short name is enough; anywhere else it must be fully qualified, with
     * the leading separator that stops PHP resolving it against $namespace.
     */
    private static function userModelRef(string $model, string $namespace): string
    {
        return Str::beforeLast($model, '\\') === $namespace
            ? Str::afterLast($model, '\\')
            : '\\'.$model;
    }

    private static function namespaceOf(string $contents): string
    {
        preg_match('/^namespace\s+([^;]+);/m', $contents, $m);

        return isset($m[1]) ? trim($m[1]) : '';
    }
}
