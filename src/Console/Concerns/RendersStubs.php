<?php

namespace ColorlibHQ\AdminLte\Console\Concerns;

use ColorlibHQ\AdminLte\Support\UserTable;

/**
 * Shared placeholder substitution for the stubs the console commands publish.
 *
 * The published code lands in the consuming app and is read and edited there, so
 * it is written out with real names baked in rather than resolving anything at
 * run time — a migration that consults config is far harder to reason about than
 * one that names its table.
 */
trait RendersStubs
{
    /**
     * @return array<string, string>
     */
    protected function stubReplacements(): array
    {
        return [
            '{{ users_model_classname }}' => UserTable::modelClassname(),
            '{{ users_key }}' => UserTable::keyName(),
            '{{ users_table }}' => UserTable::name(),
        ];
    }

    protected function renderStub(string $stubPath): string
    {
        return strtr((string) file_get_contents($stubPath), $this->stubReplacements());
    }
}
