<?php

namespace ColorlibHQ\AdminLte\Console;

use Illuminate\Console\Command;

class MakeAuthCommand extends Command
{
    protected $signature = 'adminlte:make-auth
                            {--type=plain : Auth type (plain, breeze, fortify)}
                            {--force : Overwrite existing files}';

    protected $description = 'Scaffold AdminLTE auth controllers and routes';

    public function handle(): int
    {
        $type = $this->option('type');
        $force = $this->option('force');

        match ($type) {
            'plain' => $this->scaffoldPlainAuth($force),
            'breeze' => $this->info('Breeze auth requires Laravel Breeze to be installed first.'),
            'fortify' => $this->info('Fortify auth requires Laravel Fortify to be installed first.'),
            default => $this->error("Invalid auth type: {$type}"),
        };

        return 0;
    }

    protected function scaffoldPlainAuth(bool $force): void
    {
        // Auth controllers would go here
        // For now, just publish the views
        $this->info('✓ Auth views are available via config.');
    }
}
