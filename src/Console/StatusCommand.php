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
        // Everything `adminlte:install` sets up. A gap here is a broken install.
        $required = [
            'Config (config/adminlte.php)' => File::exists(config_path('adminlte.php')),
            'JS stub (resources/js/adminlte.js)' => File::exists(resource_path('js/adminlte.js')),
            'CSS stub (resources/css/adminlte.css)' => File::exists(resource_path('css/adminlte.css')),
            'admin-lte npm package' => File::isDirectory(base_path('node_modules/admin-lte')),
            'bootstrap npm package' => File::isDirectory(base_path('node_modules/bootstrap')),
            'RTL stylesheet (public/vendor/adminlte/css)' => File::exists(public_path('vendor/adminlte/css/adminlte.rtl.min.css')),
            'ApexCharts vendor file' => File::exists(public_path('vendor/apexcharts/apexcharts.min.js')),
            'jsVectorMap vendor file' => File::exists(public_path('vendor/jsvectormap/jsvectormap.min.js')),
            'FullCalendar vendor file' => File::exists(public_path('vendor/fullcalendar/index.global.min.js')),
            'SortableJS vendor file' => File::exists(public_path('vendor/sortablejs/sortablejs.min.js')),
        ];

        // Opt-in extras — `install --only=views` and `adminlte:scaffold`.
        // Absent is a normal, fully-working state, never a warning.
        $optional = [
            'Published views (install --only=views)' => File::isDirectory(resource_path('views/vendor/adminlte')),
            'Scaffolded sections (adminlte:scaffold)' => File::isDirectory(resource_path('views/adminlte')),
        ];

        // Plugin libraries installed only if the matching component is used.
        // Each needs both `npm install` and the vendor-file copy, so listing
        // them here is the quickest way to spot a half-finished install.
        $plugins = [
            'Flatpickr  <x-adminlte-input-flatpickr>' => File::exists(public_path('vendor/flatpickr/flatpickr.min.js')),
            'Tom Select <x-adminlte-input-tom-select>' => File::exists(public_path('vendor/tom-select/tom-select.complete.min.js')),
            'Tabulator  <x-adminlte-datatable>' => File::exists(public_path('vendor/tabulator-tables/tabulator.min.js')),
            'Quill      <x-adminlte-editor>' => File::exists(public_path('vendor/quill/quill.min.js')),
        ];

        $this->newLine();
        $this->renderGroup('Required', $required, missingIsProblem: true);
        $this->newLine();
        $this->renderGroup('Optional', $optional);
        $this->newLine();
        $this->renderGroup('Optional plugins', $plugins);
        $this->newLine();

        if (array_filter($required, fn ($ok) => ! $ok)) {
            $this->components->warn('Some required resources are missing. Run: php artisan adminlte:install');
        } else {
            $this->components->info('AdminLTE 4 is fully installed.');
        }

        if (array_filter($plugins, fn ($ok) => ! $ok)) {
            $this->line('  A plugin marked <fg=gray>–</> is simply not installed. To add one:');
            $this->line('  <fg=yellow>npm install -D quill@^2.0</> (or flatpickr / tom-select / tabulator-tables)');
            $this->line('  <fg=yellow>php artisan adminlte:install --only=assets</>');
            $this->newLine();
        }

        return self::SUCCESS;
    }

    /**
     * A missing required resource is a red ✗ — something is broken. A missing
     * optional one is a grey – meaning "not installed", which is a perfectly
     * good state and shouldn't read as an error.
     *
     * @param  array<string, bool>  $checks
     */
    private function renderGroup(string $title, array $checks, bool $missingIsProblem = false): void
    {
        $this->line("  <options=bold>{$title}</>");

        foreach ($checks as $label => $ok) {
            if ($ok) {
                $this->line("  <fg=green>✓</> {$label}");
            } elseif ($missingIsProblem) {
                $this->line("  <fg=red>✗</> {$label}");
            } else {
                $this->line("  <fg=gray>–</> <fg=gray>{$label}</>");
            }
        }
    }
}
