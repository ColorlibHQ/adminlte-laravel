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
     * and tested against. fullcalendar is pinned below ^7 — v7 drops the
     * minified global bundle this package copies (index.global.min.js, now
     * an unminified all/global.js) and swaps the bundled CSS for a
     * skeleton + theme + palette model, so the calendar component needs
     * explicit work before it can move.
     */
    private const NPM_DEPENDENCIES = 'admin-lte@^4.1 bootstrap@^5.3 @popperjs/core@^2.11 '
        .'overlayscrollbars@^2.16 bootstrap-icons@^1.13 apexcharts@^6.7 jsvectormap@^1.7 '
        .'fullcalendar@^6.1 sortablejs@^1.15 sass@^1.102';

    /**
     * Optional plugin libraries (disabled by default in config/adminlte.php).
     * Listed in install guidance so users enabling those plugins know what to add.
     */
    private const NPM_OPTIONAL_DEPENDENCIES = 'flatpickr@^4.6 tom-select@^2.6 tabulator-tables@^6.5 quill@^2.0';

    /**
     * Plugin files copied out of node_modules into public/vendor. Keys are
     * source paths relative to node_modules; values are destination paths
     * relative to public/vendor (so a file can be renamed on copy).
     *
     * Every asset path in the config's `plugins` array must appear as a
     * destination here (or in self::PACKAGE_VENDOR_FILES) — otherwise the
     * plugin's <script>/<link> tag resolves to a 404 and the component that
     * enables it silently does nothing. `InstallCommandTest` enforces that.
     *
     * Sources that aren't installed are skipped silently, so the optional
     * plugins can be added later with `npm install -D …` followed by
     * `php artisan adminlte:install --only=assets`.
     *
     * @var array<string, string>
     */
    public const NODE_MODULE_VENDOR_FILES = [
        'apexcharts/dist/apexcharts.min.js' => 'apexcharts/apexcharts.min.js',
        'jsvectormap/dist/jsvectormap.min.css' => 'jsvectormap/jsvectormap.min.css',
        'jsvectormap/dist/jsvectormap.min.js' => 'jsvectormap/jsvectormap.min.js',
        'jsvectormap/dist/maps/world.js' => 'jsvectormap/maps/world.js',
        'fullcalendar/index.global.min.js' => 'fullcalendar/index.global.min.js',
        'sortablejs/Sortable.min.js' => 'sortablejs/sortablejs.min.js',
        // Optional plugins — only present once the user installs them.
        'flatpickr/dist/flatpickr.min.css' => 'flatpickr/flatpickr.min.css',
        'flatpickr/dist/flatpickr.min.js' => 'flatpickr/flatpickr.min.js',
        'tom-select/dist/css/tom-select.bootstrap5.min.css' => 'tom-select/tom-select.bootstrap5.min.css',
        'tom-select/dist/js/tom-select.complete.min.js' => 'tom-select/tom-select.complete.min.js',
        'tabulator-tables/dist/css/tabulator.min.css' => 'tabulator-tables/tabulator.min.css',
        'tabulator-tables/dist/js/tabulator.min.js' => 'tabulator-tables/tabulator.min.js',
        // Quill 2 ships a single minified UMD build named `quill.js` (the
        // `.LICENSE.txt` sibling is the minifier's), so it's renamed on copy
        // to the `quill.min.js` path the config has always pointed at.
        'quill/dist/quill.snow.css' => 'quill/quill.snow.css',
        'quill/dist/quill.js' => 'quill/quill.min.js',
        // RTL stylesheet (loaded by master.blade when layout_rtl is enabled).
        'admin-lte/dist/css/adminlte.rtl.min.css' => 'adminlte/css/adminlte.rtl.min.css',
    ];

    /**
     * Plugin files shipped inside this package rather than pulled from npm.
     * Keys are source paths relative to resources/vendor; values are
     * destination paths relative to public/vendor.
     *
     * FullCalendar 6 embeds its CSS in the JS bundle and injects it at
     * runtime — but that injection doesn't fire reliably inside the bundled
     * AdminLTE page, so the stylesheet ships here and is loaded by the
     * pluginStyles directive via the 'fullcalendar' plugin's css key.
     *
     * @var array<string, string>
     */
    public const PACKAGE_VENDOR_FILES = [
        'fullcalendar/index.global.min.css' => 'fullcalendar/index.global.min.css',
    ];

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

        // Always refresh public/vendor on a full or asset install, whether or
        // not npm ran just now. `--only=assets` is the documented way to pick
        // up an optional plugin installed after the fact.
        if (! $only || $only === 'assets') {
            $this->copyVendorFiles();
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
            $this->optionalPluginHint();

            return;
        }

        $this->components->task('Running npm install', function () {
            $result = Process::path(base_path())->run(
                'npm install -D '.self::NPM_DEPENDENCIES
            );

            return $result->successful();
        });

        $this->optionalPluginHint();
    }

    /**
     * The optional plugins aren't part of the npm step, so their vendor files
     * can't be copied until the user installs them. Spell out both halves —
     * skipping the second one leaves the plugin's assets 404ing and the
     * component that uses it silently inert.
     */
    private function optionalPluginHint(): void
    {
        $this->line('  Using an optional plugin (Flatpickr, Tom Select, Tabulator, Quill)? Install it,');
        $this->line('  then re-run the asset step to copy its files into public/vendor:');
        $this->line('  <fg=yellow>npm install -D '.self::NPM_OPTIONAL_DEPENDENCIES.'</>');
        $this->line('  <fg=yellow>php artisan adminlte:install --only=assets</>');
    }

    /**
     * Copy vendor plugin files into public/vendor, where the paths configured
     * under `plugins` in config/adminlte.php expect to find them.
     *
     * Missing sources are skipped, so this is safe to re-run at any time —
     * which is how a user picks up an optional plugin (Flatpickr, Tom Select,
     * Tabulator, Quill) installed after the initial setup.
     */
    private function copyVendorFiles(): void
    {
        $packageVendor = dirname(__DIR__, 2).'/resources/vendor';

        $sources = [];
        foreach (self::NODE_MODULE_VENDOR_FILES as $source => $destination) {
            $sources[base_path("node_modules/$source")] = $destination;
        }
        foreach (self::PACKAGE_VENDOR_FILES as $source => $destination) {
            $sources["$packageVendor/$source"] = $destination;
        }

        $copied = 0;

        $this->components->task('Copying vendor plugin files', function () use ($sources, &$copied) {
            foreach ($sources as $src => $destination) {
                if (! File::exists($src)) {
                    continue;
                }
                $dest = public_path("vendor/$destination");
                File::ensureDirectoryExists(dirname($dest));
                File::copy($src, $dest);
                $copied++;
            }

            return true;
        });

        $this->line("  <fg=gray>Copied {$copied} file(s) into public/vendor.</>");
    }
}
