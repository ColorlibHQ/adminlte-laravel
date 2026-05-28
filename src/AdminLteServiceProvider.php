<?php

namespace ColorlibHQ\AdminLte;

use ColorlibHQ\AdminLte\Console\InstallCommand;
use ColorlibHQ\AdminLte\Console\StatusCommand;
use ColorlibHQ\AdminLte\View\Components;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AdminLteServiceProvider extends ServiceProvider
{
    /**
     * The Blade components shipped by the package, keyed by their tag alias.
     * Used as <x-adminlte-card>, <x-adminlte-small-box>, etc.
     *
     * @var array<string, class-string>
     */
    private array $components = [
        'card' => Components\Widget\Card::class,
        'info-box' => Components\Widget\InfoBox::class,
        'small-box' => Components\Widget\SmallBox::class,
        'alert' => Components\Widget\Alert::class,
        'callout' => Components\Widget\Callout::class,
        'progress' => Components\Widget\Progress::class,
        'input' => Components\Form\Input::class,
        'input-switch' => Components\Form\InputSwitch::class,
        'input-color' => Components\Form\InputColor::class,
        'input-file' => Components\Form\InputFile::class,
        'textarea' => Components\Form\Textarea::class,
        'select' => Components\Form\Select::class,
        'button' => Components\Form\Button::class,
        'modal' => Components\Tool\Modal::class,
    ];

    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/adminlte.php', 'adminlte');

        // The menu builder is a singleton so menu filters/registrations
        // persist for the lifetime of the request.
        $this->app->singleton(AdminLte::class, function ($app) {
            return new AdminLte(
                $app['config']['adminlte.menu'] ?? [],
                $app['events'],
                $app
            );
        });

        $this->app->alias(AdminLte::class, 'adminlte');
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminlte');
        $this->registerComponents();
        $this->registerPublishing();
        $this->registerCommands();
    }

    /**
     * Register the package's Blade components under the `adminlte-` prefix.
     */
    private function registerComponents(): void
    {
        foreach ($this->components as $alias => $class) {
            Blade::component($class, 'adminlte-'.$alias);
        }
    }

    /**
     * Register publishable resources (config, views, frontend stubs).
     */
    private function registerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/adminlte.php' => config_path('adminlte.php'),
        ], 'adminlte-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/adminlte'),
        ], 'adminlte-views');

        $this->publishes([
            __DIR__.'/../resources/stubs/app.js.stub' => resource_path('js/adminlte.js'),
            __DIR__.'/../resources/stubs/app.css.stub' => resource_path('css/adminlte.css'),
        ], 'adminlte-assets');
    }

    /**
     * Register the package's artisan commands.
     */
    private function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
            StatusCommand::class,
        ]);
    }
}
