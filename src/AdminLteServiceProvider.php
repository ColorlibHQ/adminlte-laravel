<?php

namespace ColorlibHQ\AdminLte;

use ColorlibHQ\AdminLte\Console\InstallCommand;
use ColorlibHQ\AdminLte\Console\StatusCommand;
use ColorlibHQ\AdminLte\Plugins\PluginManager;
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
        'timeline' => Components\Widget\Timeline::class,
        'progress-group' => Components\Widget\ProgressGroup::class,
        'description-block' => Components\Widget\DescriptionBlock::class,
        'profile-card' => Components\Widget\ProfileCard::class,
        'ratings' => Components\Widget\Ratings::class,
        'nav-notifications' => Components\Widget\NavNotifications::class,
        'nav-messages' => Components\Widget\NavMessages::class,
        'nav-tasks' => Components\Widget\NavTasks::class,
        'direct-chat' => Components\Widget\DirectChat::class,
        'toast' => Components\Widget\Toast::class,
        'tabs' => Components\Widget\Tabs::class,
        'tab' => Components\Widget\Tab::class,
        'accordion' => Components\Widget\Accordion::class,
        'accordion-item' => Components\Widget\AccordionItem::class,
        'breadcrumb' => Components\Widget\Breadcrumb::class,
        'input' => Components\Form\Input::class,
        'input-switch' => Components\Form\InputSwitch::class,
        'input-color' => Components\Form\InputColor::class,
        'input-file' => Components\Form\InputFile::class,
        'input-flatpickr' => Components\Form\InputFlatpickr::class,
        'input-tom-select' => Components\Form\InputTomSelect::class,
        'textarea' => Components\Form\Textarea::class,
        'select' => Components\Form\Select::class,
        'button' => Components\Form\Button::class,
        'modal' => Components\Tool\Modal::class,
        'datatable' => Components\Tool\Datatable::class,
        'editor' => Components\Tool\Editor::class,
        'chart' => Components\Tool\Chart::class,
        'vector-map' => Components\Tool\VectorMap::class,
        'calendar' => Components\Tool\Calendar::class,
        'kanban' => Components\Tool\Kanban::class,
        'sortable' => Components\Tool\Sortable::class,
        'wizard' => Components\Tool\Wizard::class,
        'wizard-step' => Components\Tool\WizardStep::class,
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

        // Plugin manager singleton for managing optional library assets.
        $this->app->singleton(PluginManager::class, function ($app) {
            return new PluginManager($app['config']['adminlte.plugins'] ?? []);
        });
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminlte');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'adminlte');
        $this->registerComponents();
        $this->registerBladeDirectives();
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
     * Register Blade directives for plugin management.
     */
    private function registerBladeDirectives(): void
    {
        $plugins = $this->app->make(PluginManager::class);

        Blade::directive('pluginStyles', function () use ($plugins) {
            $output = '';
            foreach ($plugins->getEnabledPlugins() as $name => $config) {
                if ($css = $plugins->getCss($name)) {
                    $output .= '<link rel="stylesheet" href="'.asset($css).'">'.PHP_EOL;
                }
            }

            return $output;
        });

        Blade::directive('pluginScripts', function () use ($plugins) {
            $output = '';
            foreach ($plugins->getEnabledPlugins() as $name => $config) {
                if ($js = $plugins->getJs($name)) {
                    $output .= '<script src="'.asset($js).'"></script>'.PHP_EOL;
                }
            }

            return $output;
        });
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

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path('vendor/adminlte'),
        ], 'adminlte-lang');
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
