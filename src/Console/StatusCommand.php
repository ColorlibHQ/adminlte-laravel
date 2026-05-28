<?php

namespace ColorlibHQ\AdminLte\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StatusCommand extends Command
{
    protected $signature = 'adminlte:status';

    protected $description = 'Show which AdminLTE 4 resources are installed.';

    public function handle(): int
    {
        $checks = [
            'Config (config/adminlte.php)' => File::exists(config_path('adminlte.php')),
            'JS stub (resources/js/adminlte.js)' => File::exists(resource_path('js/adminlte.js')),
            'CSS stub (resources/css/adminlte.css)' => File::exists(resource_path('css/adminlte.css')),
            'Published views (resources/views/vendor/adminlte)' => File::isDirectory(resource_path('views/vendor/adminlte')),
            'admin-lte npm package' => File::isDirectory(base_path('node_modules/admin-lte')),
            'bootstrap npm package' => File::isDirectory(base_path('node_modules/bootstrap')),
        ];

        $this->newLine();
        foreach ($checks as $label => $ok) {
            $this->line(sprintf(
                '  %s %s',
                $ok ? '<fg=green>✓</>' : '<fg=red>✗</>',
                $label
            ));
        }
        $this->newLine();

        $missing = array_filter($checks, fn ($ok) => ! $ok);
        if ($missing) {
            $this->components->warn('Some resources are missing. Run: php artisan adminlte:install');
        } else {
            $this->components->info('AdminLTE 4 is fully installed.');
        }

        return self::SUCCESS;
    }
}
