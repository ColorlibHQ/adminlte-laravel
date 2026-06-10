<?php

namespace ColorlibHQ\AdminLte;

use ColorlibHQ\AdminLte\Console\InstallCommand;
use ColorlibHQ\AdminLte\Console\MakeAuthCommand;
use ColorlibHQ\AdminLte\Console\ScaffoldCommand;
use ColorlibHQ\AdminLte\Console\StatusCommand;
use ColorlibHQ\AdminLte\Plugins\PluginManager;
use ColorlibHQ\AdminLte\Support\ActivityLogger;
use ColorlibHQ\AdminLte\View\Components;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Translation\FileLoader;

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
        $this->registerTranslations();
        $this->registerComponents();
        $this->registerBladeDirectives();
        $this->registerPublishing();
        $this->registerCommands();
        $this->registerDemoRoutes();
        $this->registerDocsRoutes();
        $this->registerAuthorization();
        $this->registerActivityLogging();
    }

    /**
     * Auto-record auth events (login / logout / failed login) into the
     * scaffolded activity_log table. ActivityLogger no-ops when the table is
     * absent, so this is safe whether or not `adminlte:scaffold activity-log`
     * has been run.
     */
    private function registerActivityLogging(): void
    {
        $events = $this->app->make('events');

        $events->listen(Login::class, function ($event): void {
            ActivityLogger::log(
                'auth.login',
                'Signed in',
                [],
                null,
                (int) $event->user->getAuthIdentifier(),
            );
        });

        $events->listen(Logout::class, function ($event): void {
            ActivityLogger::log(
                'auth.logout',
                'Signed out',
                [],
                null,
                $event->user ? (int) $event->user->getAuthIdentifier() : null,
            );
        });

        $events->listen(Failed::class, function ($event): void {
            ActivityLogger::log(
                'auth.failed',
                'Failed login attempt',
                ['email' => $event->credentials['email'] ?? null],
            );
        });
    }

    /**
     * Opportunistically wire the RBAC layer when its published classes exist
     * (i.e. after `php artisan adminlte:scaffold rbac`): model policies, the
     * role/permission middleware aliases, and a permission-aware Gate::before.
     * All guarded by class_exists so a non-RBAC app is unaffected.
     */
    private function registerAuthorization(): void
    {
        // Model policies for the scaffolded resources. These reference the
        // consuming app's classes by name (string), so they're only wired when
        // the app has actually published them.
        $policies = [
            'App\Models\Message' => 'App\Policies\MessagePolicy',
            'App\Models\Project' => 'App\Policies\ProjectPolicy',
            'App\Models\Event' => 'App\Policies\EventPolicy',
            'App\Models\KanbanCard' => 'App\Policies\KanbanCardPolicy',
            'App\Models\Conversation' => 'App\Policies\ConversationPolicy',
        ];
        foreach ($policies as $model => $policy) {
            if (class_exists($model) && class_exists($policy)) {
                Gate::policy($model, $policy);
            }
        }

        // Middleware aliases for the published RBAC middleware.
        $router = $this->app->make('router');
        if (class_exists('App\Http\Middleware\RoleMiddleware')) {
            $router->aliasMiddleware('role', 'App\Http\Middleware\RoleMiddleware');
        }
        if (class_exists('App\Http\Middleware\PermissionMiddleware')) {
            $router->aliasMiddleware('permission', 'App\Http\Middleware\PermissionMiddleware');
        }

        // Permission-aware gate: admins pass everything; otherwise grant when the
        // user holds a permission named like the ability (e.g. @can('manage-projects')
        // or a menu item's 'can' => 'manage-projects'). Returns null to fall through.
        if (class_exists('App\Models\Permission')) {
            Gate::before(function ($user, string $ability) {
                if (! is_object($user)) {
                    return null;
                }
                if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                    return true;
                }
                if (method_exists($user, 'hasPermission') && $user->hasPermission($ability)) {
                    return true;
                }

                return null;
            });
        }
    }

    /**
     * Serve the package documentation (the markdown files under /docs) inside
     * the app at /docs and /docs/{page}, rendered with the AdminLTE layout.
     * Enabled by default; disable with `'docs' => false` in config.
     */
    private function registerDocsRoutes(): void
    {
        if (! config('adminlte.docs', true)) {
            return;
        }

        /** @var array<int, string> $middleware */
        $middleware = config('adminlte.docs_middleware', ['web']);
        $docsPath = dirname(__DIR__).'/docs';

        // Ordered navigation: file slug => sidebar label.
        $nav = [
            'README' => 'Overview',
            'installation' => 'Installation',
            'configuration' => 'Configuration',
            'layout' => 'Layout',
            'menu' => 'Menu',
            'components' => 'Components',
            'plugins' => 'Plugins',
            'scaffolding' => 'Scaffolding',
            'dashboard' => 'Dashboard',
            'authentication' => 'Authentication',
            'authorization' => 'Authorization',
            'account-management' => 'Account management',
            'notifications' => 'Notifications',
            'activity-log' => 'Activity log',
            'api' => 'API tokens',
            'realtime' => 'Real-time',
            'commands' => 'Commands',
            'translations' => 'Translations',
            'demo-pages' => 'Demo pages',
            'deployment' => 'Deployment',
            'contributing' => 'Contributing',
        ];

        Route::middleware($middleware)->group(function () use ($docsPath, $nav) {
            Route::get('docs/{page?}', function (string $page = 'README') use ($docsPath, $nav) {
                $slug = preg_replace('/[^A-Za-z0-9_-]/', '', $page) ?: 'README';
                $file = $docsPath.'/'.$slug.'.md';

                abort_unless(is_file($file), 404);

                // Defense-in-depth: the slug regex above already blocks
                // traversal; assert the resolved path stays inside docs/ so
                // a future regex change can't silently reintroduce it.
                $realFile = realpath($file);
                $realDocs = realpath($docsPath);
                abort_unless(
                    $realFile !== false
                    && $realDocs !== false
                    && str_starts_with($realFile, $realDocs.DIRECTORY_SEPARATOR),
                    404
                );

                $markdown = (string) file_get_contents($file);
                // Str::markdown() already uses the GitHub-flavored converter
                // (tables, fenced code, strikethrough, autolinks).
                $html = Str::markdown($markdown);

                // Rewrite intra-doc links (foo.md / foo.md#frag) to /docs/foo,
                // leaving external (http) links untouched.
                $base = url('docs');
                $html = preg_replace_callback(
                    '/href="(?!https?:\/\/)([A-Za-z0-9_-]+)\.md(#[^"]*)?"/',
                    fn ($m) => 'href="'.$base.'/'.$m[1].($m[2] ?? '').'"',
                    $html
                );

                return view('adminlte::docs', [
                    'nav' => $nav,
                    'current' => $slug,
                    'title' => $nav[$slug] ?? Str::headline($slug),
                    'html' => $html,
                ]);
            })->name('adminlte.docs');
        });
    }

    /**
     * Register routes for the bundled demo/showcase pages (Dashboard v2/v3,
     * Widgets, UI Elements, Forms, Tables, Layout Options, Theme Generate,
     * auth variants, error pages). Enabled by default so a fresh install
     * mirrors the AdminLTE demo; disable with `'demo' => false` in config.
     */
    private function registerDemoRoutes(): void
    {
        if (! config('adminlte.demo', true)) {
            return;
        }

        /** @var array<int, string> $middleware */
        $middleware = config('adminlte.demo_middleware', ['web', 'auth']);

        // uri => blade view (route name is "adminlte.demo." + dotted uri tail)
        $pages = [
            'demo/dashboard-v2' => 'demo.dashboard2',
            'demo/dashboard-v3' => 'demo.dashboard3',
            'demo/theme-generator' => 'demo.theme-generator',
            'demo/layout-options' => 'demo.layout-options',
            'demo/widgets/small-box' => 'demo.widgets.small-box',
            'demo/widgets/info-box' => 'demo.widgets.info-box',
            'demo/widgets/cards' => 'demo.widgets.cards',
            'demo/ui/general' => 'demo.ui.general',
            'demo/ui/icons' => 'demo.ui.icons',
            'demo/ui/timeline' => 'demo.ui.timeline',
            'demo/forms/elements' => 'demo.forms.elements',
            'demo/forms/layout' => 'demo.forms.layout',
            'demo/forms/validation' => 'demo.forms.validation',
            'demo/forms/wizard' => 'demo.forms.wizard',
            'demo/tables/simple' => 'demo.tables.simple',
            'demo/tables/data' => 'demo.tables.data',
            'demo/auth/login-v2' => 'auth.login-v2',
            'demo/auth/register-v2' => 'auth.register-v2',
            'demo/auth/lockscreen' => 'auth.lockscreen',
            'demo/errors/404' => 'errors.404',
            'demo/errors/500' => 'errors.500',
            'demo/errors/maintenance' => 'errors.maintenance',
        ];

        Route::middleware($middleware)->group(function () use ($pages) {
            foreach ($pages as $uri => $view) {
                Route::view($uri, 'adminlte::'.$view)->name('adminlte.'.str_replace('/', '.', $uri));
            }
        });
    }

    /**
     * Register the package's translations.
     *
     * The views reference keys as `__('adminlte.key')` — i.e. the `adminlte`
     * group in the default namespace. We register the package lang directory
     * as an additional default-namespace path so those keys resolve out of the
     * box (no publishing required), while also keeping the `adminlte::` hint
     * available for anyone who prefers the namespaced accessor.
     */
    private function registerTranslations(): void
    {
        $langPath = __DIR__.'/../resources/lang';

        $this->loadTranslationsFrom($langPath, 'adminlte');

        $loader = $this->app->make('translator')->getLoader();

        if ($loader instanceof FileLoader) {
            $loader->addPath($langPath);
        }
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
     * These directives execute at REQUEST TIME, not compile time,
     * so plugins enabled by components are properly reflected.
     */
    private function registerBladeDirectives(): void
    {
        Blade::directive('pluginStyles', function () {
            return "<?php echo app('".PluginManager::class."')->renderStyles(); ?>";
        });

        Blade::directive('pluginScripts', function () {
            return "<?php echo app('".PluginManager::class."')->renderScripts(); ?>";
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
            ScaffoldCommand::class,
            MakeAuthCommand::class,
        ]);
    }
}
