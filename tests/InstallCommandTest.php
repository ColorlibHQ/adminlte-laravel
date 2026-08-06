<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Console\InstallCommand;
use Illuminate\Support\Facades\File;

class InstallCommandTest extends TestCase
{
    /**
     * Every asset a plugin points at must actually be delivered to
     * public/vendor by the installer. When it isn't, the plugin's
     * <script>/<link> tag 404s and the component that enables it renders
     * inert markup with no error anywhere — which is exactly how Flatpickr,
     * Tom Select, Tabulator and Quill shipped broken.
     *
     * @see https://github.com/ColorlibHQ/adminlte-laravel/issues/6
     */
    public function test_every_configured_plugin_asset_is_copied_by_the_installer(): void
    {
        $destinations = array_merge(
            array_values(InstallCommand::NODE_MODULE_VENDOR_FILES),
            array_values(InstallCommand::PACKAGE_VENDOR_FILES),
        );

        /** @var array<string, array<string, mixed>> $plugins */
        $plugins = config('adminlte.plugins');

        foreach ($plugins as $name => $settings) {
            foreach (['css', 'js'] as $type) {
                foreach ((array) ($settings[$type] ?? []) as $path) {
                    // Only paths the package owns; an app may point a plugin
                    // at its own asset or a CDN, which is none of our business.
                    if (! str_starts_with($path, 'vendor/')) {
                        continue;
                    }

                    $this->assertContains(
                        substr($path, strlen('vendor/')),
                        $destinations,
                        "Plugin '{$name}' declares {$type} '{$path}', but adminlte:install never copies a file there."
                    );
                }
            }
        }
    }

    /**
     * The npm sources are the other half of the same contract: a destination
     * with no source is a path that silently stays empty.
     */
    public function test_vendor_sources_are_distinct_and_non_empty(): void
    {
        $map = InstallCommand::NODE_MODULE_VENDOR_FILES;

        $this->assertNotEmpty($map);
        $this->assertSame(
            count($map),
            count(array_unique(array_values($map))),
            'Two node_modules sources are copied to the same public/vendor path.'
        );

        foreach ($map as $source => $destination) {
            $this->assertStringContainsString('/', $source, "Source '{$source}' is not a path inside a package.");
            $this->assertStringNotContainsString('..', $source);
            $this->assertStringNotContainsString('..', $destination);
        }
    }

    /**
     * The bundled FullCalendar stylesheet is shipped in this package rather
     * than pulled from npm, so it has to exist on disk.
     */
    public function test_package_shipped_vendor_files_exist(): void
    {
        foreach (array_keys(InstallCommand::PACKAGE_VENDOR_FILES) as $source) {
            $this->assertFileExists(dirname(__DIR__)."/resources/vendor/{$source}");
        }
    }

    /**
     * End-to-end: with the optional libraries present in node_modules,
     * `install --only=assets` must land every one of them in public/vendor
     * under the exact filename the config points at (Quill in particular is
     * renamed on copy, since it ships its minified build as `quill.js`).
     */
    public function test_install_copies_optional_plugin_files_into_public_vendor(): void
    {
        $root = sys_get_temp_dir().'/adminlte-install-'.getmypid();
        File::deleteDirectory($root);

        // Stand in for the real packages — copyVendorFiles() only cares that
        // the source path exists.
        foreach (array_keys(InstallCommand::NODE_MODULE_VENDOR_FILES) as $source) {
            $path = "{$root}/node_modules/{$source}";
            File::ensureDirectoryExists(dirname($path));
            File::put($path, "/* {$source} */");
        }

        $this->app->setBasePath($root);
        $this->app->usePublicPath("{$root}/public");

        $this->artisan('adminlte:install', ['--only' => 'assets'])->assertSuccessful();

        foreach (InstallCommand::NODE_MODULE_VENDOR_FILES as $source => $destination) {
            $this->assertFileExists("{$root}/public/vendor/{$destination}");
            $this->assertSame("/* {$source} */", File::get("{$root}/public/vendor/{$destination}"));
        }

        // The package-shipped FullCalendar stylesheet rides along too.
        foreach (InstallCommand::PACKAGE_VENDOR_FILES as $destination) {
            $this->assertFileExists("{$root}/public/vendor/{$destination}");
        }

        // The paths the plugin config actually requests must all resolve.
        $this->assertFileExists("{$root}/public/vendor/quill/quill.min.js");
        $this->assertFileExists("{$root}/public/vendor/quill/quill.snow.css");
        $this->assertFileExists("{$root}/public/vendor/tom-select/tom-select.complete.min.js");
        $this->assertFileExists("{$root}/public/vendor/tabulator-tables/tabulator.min.js");
        $this->assertFileExists("{$root}/public/vendor/flatpickr/flatpickr.min.js");

        File::deleteDirectory($root);
    }

    /**
     * A user who hasn't installed the optional libraries must still get a
     * clean install — missing sources are skipped, not fatal.
     */
    public function test_install_succeeds_when_optional_plugins_are_absent(): void
    {
        $root = sys_get_temp_dir().'/adminlte-install-bare-'.getmypid();
        File::deleteDirectory($root);
        File::ensureDirectoryExists($root);

        $this->app->setBasePath($root);
        $this->app->usePublicPath("{$root}/public");

        $this->artisan('adminlte:install', ['--only' => 'assets'])->assertSuccessful();

        $this->assertFileDoesNotExist("{$root}/public/vendor/quill/quill.min.js");

        File::deleteDirectory($root);
    }
}
