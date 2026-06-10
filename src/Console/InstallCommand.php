<?php

namespace ColorlibHQ\AdminLte\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class InstallCommand extends Command
{
    /**
     * Core frontend dependencies, pinned to the major (or minor, where the
     * next release line is known to break) versions this package is built
     * and tested against. fullcalendar is pinned below ^7 — v7 removes the
     * bundled CSS and the Bootstrap 5 theme, which breaks the calendar
     * component until the package explicitly supports it.
     */
    private const NPM_DEPENDENCIES = 'admin-lte@^4.0 bootstrap@^5.3 @popperjs/core@^2.11 '
        .'overlayscrollbars@^2.0 bootstrap-icons@^1.13 apexcharts@^5.0 jsvectormap@^1.7 '
        .'fullcalendar@^6.1 sortablejs@^1.15 sass@^1.77';

    /**
     * Optional plugin libraries (disabled by default in config/adminlte.php).
     * Listed in install guidance so users enabling those plugins know what to add.
     */
    private const NPM_OPTIONAL_DEPENDENCIES = 'flatpickr@^4.6 tom-select@^2.4 tabulator-tables@^6.0 quill@^2.0';

    protected $signature = 'adminlte:install
        {--only= : Install only a specific resource (config|views|assets|lang)}
        {--force : Overwrite existing files}
        {--no-interaction-deps : Skip the npm install prompt}';

    protected $description = 'Install the AdminLTE 4 scaffolding (config, Vite assets, frontend deps).';

    public function handle(): int
    {
        $this->components->info('Installing AdminLTE 4 for Laravel');

        $only = $this->option('only');

        if (! $only || $only === 'config') {
            $this->publishTag('adminlte-config', 'config');
        }

        if (! $only || $only === 'assets') {
            $this->publishTag('adminlte-assets', 'frontend stubs');
            $this->wireVite();
        }

        if ($only === 'views') {
            $this->publishTag('adminlte-views', 'views');
        }

        if ($only === 'lang') {
            $this->publishTag('adminlte-lang', 'language files');
        }

        if (! $only) {
            $this->installFrontendDependencies();
        }

        $this->newLine();
        $this->components->info('AdminLTE installed. Next steps:');
        $this->line('  1. Ensure resources/js/adminlte.js & resources/css/adminlte.css are in your vite.config.js input.');
        $this->line('  2. Run <fg=yellow>npm run dev</> (or <fg=yellow>npm run build</>).');
        $this->line('  3. Extend the layout in a view: <fg=yellow>@extends(\'adminlte::page\')</>');
        $this->line('  4. Configure your sidebar menu in <fg=yellow>config/adminlte.php</>.');

        return self::SUCCESS;
    }

    private function publishTag(string $tag, string $label): void
    {
        $this->components->task("Publishing {$label}", function () use ($tag) {
            $params = ['--tag' => $tag];
            if ($this->option('force')) {
                $params['--force'] = true;
            }
            $this->callSilently('vendor:publish', $params);

            return true;
        });
    }

    /**
     * Add admin-lte + bootstrap imports to the published stubs if not present,
     * and make sure they're referenced by Vite. We don't rewrite the user's
     * vite.config.js automatically — we print guidance instead, to avoid
     * clobbering custom configs.
     */
    private function wireVite(): void
    {
        $viteConfig = base_path('vite.config.js');

        if (! File::exists($viteConfig)) {
            return;
        }

        $contents = File::get($viteConfig);

        if (str_contains($contents, 'resources/js/adminlte.js')) {
            return; // already wired
        }

        $this->components->warn(
            "Add 'resources/css/adminlte.css' and 'resources/js/adminlte.js' to the "
            .'laravel({ input: [...] }) array in vite.config.js.'
        );
    }

    private function installFrontendDependencies(): void
    {
        if ($this->option('no-interaction-deps')) {
            return;
        }

        if (! $this->confirm('Install frontend dependencies (admin-lte, bootstrap, plugin libraries, etc.) via npm now?', true)) {
            $this->line('Skipped. Install manually with:');
            $this->line('  <fg=yellow>npm install -D '.self::NPM_DEPENDENCIES.'</>');
            $this->line('  Optional plugins (Flatpickr, Tom Select, Tabulator, Quill — disabled by default):');
            $this->line('  <fg=yellow>npm install -D '.self::NPM_OPTIONAL_DEPENDENCIES.'</>');

            return;
        }

        $this->components->task('Running npm install', function () {
            $result = Process::path(base_path())->run(
                'npm install -D '.self::NPM_DEPENDENCIES
            );

            return $result->successful();
        });

        $this->line('  Using an optional plugin (Flatpickr, Tom Select, Tabulator, Quill)? Add it with:');
        $this->line('  <fg=yellow>npm install -D '.self::NPM_OPTIONAL_DEPENDENCIES.'</>');

        $this->copyVendorFiles();
    }

    /**
     * Copy vendor plugin files from node_modules to public/vendor.
     * Keys are source paths relative to node_modules; values are destination
     * paths relative to public/vendor (so a file can be renamed on copy).
     */
    private function copyVendorFiles(): void
    {
        $vendorFiles = [
            'apexcharts/dist/apexcharts.min.js' => 'apexcharts/apexcharts.min.js',
            'jsvectormap/dist/jsvectormap.min.css' => 'jsvectormap/jsvectormap.min.css',
            'jsvectormap/dist/jsvectormap.min.js' => 'jsvectormap/jsvectormap.min.js',
            'jsvectormap/dist/maps/world.js' => 'jsvectormap/maps/world.js',
            'fullcalendar/index.global.min.js' => 'fullcalendar/index.global.min.js',
            'sortablejs/Sortable.min.js' => 'sortablejs/sortablejs.min.js',
            // RTL stylesheet (loaded by master.blade when layout_rtl is enabled).
            'admin-lte/dist/css/adminlte.rtl.min.css' => 'adminlte/css/adminlte.rtl.min.css',
        ];

        $this->components->task('Copying vendor plugin files', function () use ($vendorFiles) {
            foreach ($vendorFiles as $source => $destination) {
                $src = base_path("node_modules/$source");
                if (! File::exists($src)) {
                    continue;
                }
                $dest = public_path("vendor/$destination");
                File::ensureDirectoryExists(dirname($dest));
                File::copy($src, $dest);
            }

            // FullCalendar 6 embeds its CSS in the JS bundle and injects it at
            // runtime — but that injection doesn't fire reliably inside the
            // bundled AdminLTE page, so we ship the stylesheet explicitly and
            // load it via @pluginStyles (the 'fullcalendar' plugin's css key).
            $fcCss = dirname(__DIR__, 2).'/resources/vendor/fullcalendar/index.global.min.css';
            if (File::exists($fcCss)) {
                $fcDest = public_path('vendor/fullcalendar/index.global.min.css');
                File::ensureDirectoryExists(dirname($fcDest));
                File::copy($fcCss, $fcDest);
            }

            return true;
        });
    }
}
