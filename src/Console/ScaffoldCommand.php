<?php

namespace ColorlibHQ\AdminLte\Console;

use Illuminate\Console\Command;

class ScaffoldCommand extends Command
{
    protected $signature = 'adminlte:scaffold
                            {section? : The section to scaffold (mailbox, chat, kanban, calendar, projects, file-manager, profile, settings, invoice, pricing, faq)}
                            {--all : Scaffold all sections}
                            {--force : Overwrite existing files}
                            {--seed : Run seeders after publishing}';

    protected $description = 'Scaffold AdminLTE sections (mailbox, chat, kanban, etc.) with full DB backing';

    /**
     * @var array<string, string>
     */
    protected array $sections = [
        'dashboard' => 'Data-driven dashboard with real stats from your scaffolded models',
        'mailbox' => 'Messages mailbox with inbox/read/compose',
        'chat' => 'Conversations and chat messaging',
        'kanban' => 'Kanban boards with drag-to-reorder cards',
        'calendar' => 'Event calendar with FullCalendar',
        'projects' => 'Project management CRUD',
        'file-manager' => 'File browser using Laravel Storage',
        'profile' => 'User profile page',
        'settings' => 'User settings page',
        'invoice' => 'Invoice generator',
        'pricing' => 'Pricing page',
        'faq' => 'FAQ accordion',
        'notifications' => 'Database notifications wired into the navbar bell + a notifications page',
        'impersonation' => 'Log in as another user (RBAC-gated) with a revert banner',
        'activity-log' => 'Activity/audit log with a viewer + a LogsActivity model trait',
        'rbac' => 'Roles & permissions (RBAC) with user/role management UI',
    ];

    /**
     * Declarative manifest of what each section publishes.
     * Each entry may define: migrations[], models[], controllers[],
     * seeders[] (class => stub file), views (dir), routes (stub), seeder (class to run).
     *
     * @var array<string, array<string, mixed>>
     */
    protected array $manifest = [
        'dashboard' => [
            'controllers' => ['DashboardController'],
            'tests' => ['DashboardTest'],
            'views' => 'dashboard',
            'routes' => 'dashboard',
        ],
        'mailbox' => [
            'migrations' => ['create_adminlte_messages_table'],
            'models' => ['Message'],
            'factories' => ['MessageFactory'],
            'requests' => ['StoreMessageRequest'],
            'policies' => ['MessagePolicy'],
            'controllers' => ['MailboxController'],
            'seeders' => ['AdminLteMailboxSeeder'],
            'tests' => ['MailboxTest'],
            'views' => 'mailbox',
            'routes' => 'mailbox',
            'seeder' => 'AdminLteMailboxSeeder',
        ],
        'chat' => [
            'migrations' => ['create_adminlte_conversations_table'],
            'models' => ['Conversation', 'ChatMessage'],
            'factories' => ['ConversationFactory', 'ChatMessageFactory'],
            'requests' => ['StoreChatMessageRequest'],
            'policies' => ['ConversationPolicy'],
            'controllers' => ['ChatController'],
            'seeders' => ['AdminLteChatSeeder'],
            'tests' => ['ChatTest'],
            'views' => 'chat',
            'routes' => 'chat',
            'seeder' => 'AdminLteChatSeeder',
        ],
        'kanban' => [
            'migrations' => ['create_adminlte_kanban_tables'],
            'models' => ['KanbanBoard', 'KanbanLane', 'KanbanCard'],
            'factories' => ['KanbanBoardFactory', 'KanbanLaneFactory', 'KanbanCardFactory'],
            'requests' => ['StoreKanbanCardRequest'],
            'policies' => ['KanbanCardPolicy'],
            'controllers' => ['KanbanController'],
            'seeders' => ['AdminLteKanbanSeeder'],
            'tests' => ['KanbanTest'],
            'views' => 'kanban',
            'routes' => 'kanban',
            'seeder' => 'AdminLteKanbanSeeder',
        ],
        'calendar' => [
            'migrations' => ['create_adminlte_events_table'],
            'models' => ['Event'],
            'factories' => ['EventFactory'],
            'requests' => ['StoreEventRequest', 'UpdateEventRequest'],
            'policies' => ['EventPolicy'],
            'controllers' => ['CalendarController'],
            'seeders' => ['AdminLteCalendarSeeder'],
            'tests' => ['CalendarTest'],
            'views' => 'calendar',
            'routes' => 'calendar',
            'seeder' => 'AdminLteCalendarSeeder',
        ],
        'projects' => [
            'migrations' => ['create_adminlte_projects_table'],
            'models' => ['Project'],
            'factories' => ['ProjectFactory'],
            'requests' => ['StoreProjectRequest', 'UpdateProjectRequest'],
            'policies' => ['ProjectPolicy'],
            'controllers' => ['ProjectsController'],
            'seeders' => ['AdminLteProjectsSeeder'],
            'tests' => ['ProjectsTest'],
            'views' => 'projects',
            'routes' => 'projects',
            'seeder' => 'AdminLteProjectsSeeder',
        ],
        'file-manager' => [
            'controllers' => ['FileManagerController'],
            'views' => 'file-manager',
            'routes' => 'file-manager',
        ],
        'profile' => [
            'migrations' => ['add_profile_fields_to_users_table'],
            'requests' => ['UpdateProfileRequest', 'UpdatePasswordRequest'],
            'controllers' => ['ProfileController'],
            'tests' => ['ProfileTest'],
            'views' => 'profile',
            'routes' => 'profile',
        ],
        'settings' => [
            'controllers' => ['SettingsController'],
            'views' => 'settings',
            'routes' => 'settings',
        ],
        'invoice' => [
            'controllers' => ['InvoiceController'],
            'views' => 'invoice',
            'routes' => 'invoice',
        ],
        'pricing' => [
            'views' => 'pricing',
            'routes' => 'pricing',
        ],
        'faq' => [
            'views' => 'faq',
            'routes' => 'faq',
        ],
        'notifications' => [
            'migrations' => ['create_notifications_table'],
            'notifications' => ['AdminLteDemoNotification'],
            'controllers' => ['NotificationController'],
            'seeders' => ['AdminLteNotificationsSeeder'],
            'tests' => ['NotificationsTest'],
            'views' => 'notifications',
            'routes' => 'notifications',
            'seeder' => 'AdminLteNotificationsSeeder',
        ],
        'impersonation' => [
            'controllers' => ['ImpersonationController'],
            'routes' => 'impersonation',
        ],
        'activity-log' => [
            'migrations' => ['create_activity_log_table'],
            'models' => ['Activity'],
            'concerns' => ['LogsActivity'],
            'controllers' => ['ActivityController'],
            'tests' => ['ActivityLogTest'],
            'views' => 'activity',
            'routes' => 'activity',
        ],
        // RBAC is handled by scaffoldRbac(); the seeder key wires up --seed.
        'rbac' => [
            'seeder' => 'AdminLteRbacSeeder',
        ],
    ];

    public function handle(): int
    {
        $force = (bool) $this->option('force');
        $seed = (bool) $this->option('seed');

        if ($this->option('all')) {
            foreach (array_keys($this->sections) as $section) {
                $this->scaffoldSection($section, $force);
            }
            $this->info('✓ All sections scaffolded.');
            $this->printNextSteps();

            if ($seed) {
                $this->runSeeders(array_keys($this->sections));
            }

            return self::SUCCESS;
        }

        $section = $this->argument('section');

        if (is_string($section) && $section !== '') {
            if (! isset($this->sections[$section])) {
                $this->error("Section '{$section}' not found. Available: ".implode(', ', array_keys($this->sections)));

                return self::FAILURE;
            }

            $this->scaffoldSection($section, $force);
            $this->printNextSteps();

            if ($seed) {
                $this->runSeeders([$section]);
            }

            return self::SUCCESS;
        }

        /** @var array<int, string> $selected */
        $selected = (array) $this->choice(
            'Which sections would you like to scaffold?',
            array_keys($this->sections),
            null,
            null,
            true
        );

        foreach ($selected as $sect) {
            $this->scaffoldSection($sect, $force);
        }
        $this->printNextSteps();

        if ($seed) {
            $this->runSeeders($selected);
        }

        return self::SUCCESS;
    }

    protected function scaffoldSection(string $section, bool $force): void
    {
        $this->components->info("Scaffolding '{$section}'");

        if ($section === 'rbac') {
            $this->scaffoldRbac($force);

            return;
        }

        $spec = $this->manifest[$section] ?? [];

        $migrations = (array) ($spec['migrations'] ?? []);
        foreach (array_values($migrations) as $i => $migration) {
            // Stagger timestamps so migrations run in a deterministic order.
            $timestamp = date('Y_m_d_His', time() + $i);
            $this->publishFile(
                "stubs/migrations/{$migration}.php.stub",
                database_path("migrations/{$timestamp}_{$migration}.php"),
                $force
            );
        }

        foreach ((array) ($spec['models'] ?? []) as $model) {
            $this->publishFile(
                "stubs/models/{$model}.php.stub",
                app_path("Models/{$model}.php"),
                $force
            );
        }

        foreach ((array) ($spec['factories'] ?? []) as $factory) {
            $this->publishFile(
                "stubs/factories/{$factory}.php.stub",
                database_path("factories/{$factory}.php"),
                $force
            );
        }

        foreach ((array) ($spec['requests'] ?? []) as $request) {
            $this->publishFile(
                "stubs/requests/{$request}.php.stub",
                app_path("Http/Requests/AdminLte/{$request}.php"),
                $force
            );
        }

        foreach ((array) ($spec['policies'] ?? []) as $policy) {
            $this->publishFile(
                "stubs/policies/{$policy}.php.stub",
                app_path("Policies/{$policy}.php"),
                $force
            );
        }

        foreach ((array) ($spec['tests'] ?? []) as $test) {
            $this->publishFile(
                "stubs/tests/{$test}.php.stub",
                base_path("tests/Feature/AdminLte/{$test}.php"),
                $force
            );
        }

        foreach ((array) ($spec['notifications'] ?? []) as $notification) {
            $this->publishFile(
                "stubs/notifications/{$notification}.php.stub",
                app_path("Notifications/{$notification}.php"),
                $force
            );
        }

        foreach ((array) ($spec['concerns'] ?? []) as $concern) {
            $this->publishFile(
                "stubs/concerns/{$concern}.php.stub",
                app_path("Models/Concerns/{$concern}.php"),
                $force
            );
        }

        foreach ((array) ($spec['controllers'] ?? []) as $controller) {
            $this->publishFile(
                "stubs/controllers/{$controller}.php.stub",
                app_path("Http/Controllers/AdminLte/{$controller}.php"),
                $force
            );
        }

        foreach ((array) ($spec['seeders'] ?? []) as $seeder) {
            $this->publishFile(
                "stubs/seeders/{$seeder}.php.stub",
                database_path("seeders/{$seeder}.php"),
                $force
            );
        }

        if (! empty($spec['views'])) {
            $this->publishDirectory(
                "stubs/views/{$spec['views']}",
                resource_path("views/adminlte/{$spec['views']}"),
                $force
            );
        }

        if (! empty($spec['routes'])) {
            $this->appendRoutes($section, (string) $spec['routes']);
        }
    }

    /**
     * Scaffold the native roles & permissions (RBAC) layer: tables, models,
     * the HasRoles trait, middleware, seeder, management UI, and routes — then
     * wire the HasRoles trait into the app's User model.
     */
    protected function scaffoldRbac(bool $force): void
    {
        $timestamp = date('Y_m_d_His');

        $this->publishFile(
            'stubs/rbac/migrations/create_adminlte_rbac_tables.php.stub',
            database_path("migrations/{$timestamp}_create_adminlte_rbac_tables.php"),
            $force
        );

        foreach (['Role', 'Permission'] as $model) {
            $this->publishFile(
                "stubs/rbac/models/{$model}.php.stub",
                app_path("Models/{$model}.php"),
                $force
            );
        }

        $this->publishFile(
            'stubs/rbac/models/HasRoles.php.stub',
            app_path('Models/Concerns/HasRoles.php'),
            $force
        );

        foreach (['Role', 'Permission'] as $model) {
            $this->publishFile(
                "stubs/factories/{$model}Factory.php.stub",
                database_path("factories/{$model}Factory.php"),
                $force
            );
        }

        foreach (['RoleMiddleware', 'PermissionMiddleware'] as $mw) {
            $this->publishFile(
                "stubs/rbac/middleware/{$mw}.php.stub",
                app_path("Http/Middleware/{$mw}.php"),
                $force
            );
        }

        $this->publishFile(
            'stubs/rbac/seeders/AdminLteRbacSeeder.php.stub',
            database_path('seeders/AdminLteRbacSeeder.php'),
            $force
        );

        foreach (['UserController', 'RoleController'] as $controller) {
            $this->publishFile(
                "stubs/rbac/controllers/{$controller}.php.stub",
                app_path("Http/Controllers/AdminLte/{$controller}.php"),
                $force
            );
        }

        foreach (['users', 'roles'] as $dir) {
            $this->publishDirectory(
                "stubs/rbac/views/{$dir}",
                resource_path("views/adminlte/{$dir}"),
                $force
            );
            $this->appendRoutes($dir, $dir);
        }

        $this->injectHasRolesIntoUser();
    }

    /**
     * Add the HasRoles trait to the app's User model (idempotent).
     */
    protected function injectHasRolesIntoUser(): void
    {
        $userModel = app_path('Models/User.php');

        if (! file_exists($userModel)) {
            $this->warn('  app/Models/User.php not found — add "use App\Models\Concerns\HasRoles;" manually.');

            return;
        }

        $contents = (string) file_get_contents($userModel);

        if (str_contains($contents, 'HasRoles')) {
            $this->line('  <comment>User model already uses HasRoles</comment>');

            return;
        }

        // Add the import after the namespace declaration.
        $contents = preg_replace(
            '/^(namespace App\\\\Models;\s*)$/m',
            "$1\nuse App\\Models\\Concerns\\HasRoles;",
            $contents,
            1
        );

        // Add `use HasRoles;` to the first trait-use inside the class, or after the class brace.
        if (preg_match('/(class User extends \w+[^{]*\{\s*\n)(\s*)use /', (string) $contents)) {
            $contents = preg_replace(
                '/(class User extends \w+[^{]*\{\s*\n)(\s*)use ([^;]+);/',
                '$1$2use HasRoles, $3;',
                (string) $contents,
                1
            );
        } else {
            $contents = preg_replace(
                '/(class User extends \w+[^{]*\{\s*\n)/',
                "$1    use HasRoles;\n\n",
                (string) $contents,
                1
            );
        }

        file_put_contents($userModel, $contents);
        $this->line('  <info>✓</info> added HasRoles trait to app/Models/User.php');
    }

    /**
     * Append a section's route definitions into a managed block in routes/web.php.
     */
    protected function appendRoutes(string $section, string $routeStub): void
    {
        $webRoutes = base_path('routes/web.php');

        if (! file_exists($webRoutes)) {
            $this->warn('  routes/web.php not found — skipping route registration.');

            return;
        }

        $contents = (string) file_get_contents($webRoutes);
        $marker = '// AdminLTE scaffold routes';
        $sectionMarker = "// [adminlte:{$section}]";

        // Already registered — don't duplicate.
        if (str_contains($contents, $sectionMarker)) {
            $this->line("  <comment>routes already present for '{$section}'</comment>");

            return;
        }

        $snippet = rtrim((string) file_get_contents(__DIR__."/../../resources/stubs/routes/{$routeStub}.php.stub"));
        $block = "    {$sectionMarker}\n{$snippet}\n";

        if (str_contains($contents, $marker)) {
            // Insert into the existing managed group, right after the opening marker.
            $contents = (string) preg_replace(
                '/('.preg_quote($marker, '/').'.*?\{)/s',
                "$1\n{$block}",
                $contents,
                1
            );
        } else {
            // Create the managed group at the end of the file.
            $group = "\n{$marker}\n";
            $group .= "Route::middleware(['web', 'auth'])->prefix('admin')->name('adminlte.')->group(function () {\n";
            $group .= "{$block}";
            $group .= "});\n";
            $contents .= $group;
        }

        file_put_contents($webRoutes, $contents);
        $this->line("  <info>✓</info> routes registered for '{$section}'");
    }

    /**
     * @param  array<int, string>  $sections
     */
    protected function runSeeders(array $sections): void
    {
        foreach ($sections as $section) {
            $seeder = $this->manifest[$section]['seeder'] ?? null;
            if (! is_string($seeder) || $seeder === '') {
                continue;
            }

            $this->call('migrate', ['--force' => true]);
            $this->call('db:seed', ['--class' => $seeder, '--force' => true]);
        }
    }

    protected function printNextSteps(): void
    {
        $this->newLine();
        $this->components->info('Scaffolding complete. Next steps:');
        $this->line('  1. Run <fg=yellow>php artisan migrate</> to create the tables.');
        $this->line('  2. Run <fg=yellow>php artisan db:seed --class=AdminLte{Section}Seeder</> for demo data.');
        $this->line('  3. Add menu items in <fg=yellow>config/adminlte.php</> pointing to the new routes (prefixed <fg=yellow>adminlte.</>).');
        $this->line('  4. Visit <fg=yellow>/admin/{section}</> (requires authentication).');
    }

    protected function publishFile(string $stub, string $path, bool $force): void
    {
        if (file_exists($path) && ! $force) {
            $this->line("  <comment>exists</comment> {$path}");

            return;
        }

        $stubPath = __DIR__.'/../../resources/'.$stub;

        if (! file_exists($stubPath)) {
            $this->warn("  missing stub: {$stub}");

            return;
        }

        $content = file_get_contents($stubPath);
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, recursive: true);
        }
        file_put_contents($path, $content);
        $this->line("  <info>✓</info> {$path}");
    }

    protected function publishDirectory(string $stub, string $path, bool $force): void
    {
        $stubPath = __DIR__.'/../../resources/'.$stub;
        if (! is_dir($stubPath)) {
            return;
        }

        if (! is_dir($path)) {
            mkdir($path, 0755, recursive: true);
        }

        foreach (glob($stubPath.'/*') ?: [] as $file) {
            $dest = $path.'/'.basename($file);
            if (file_exists($dest) && ! $force) {
                continue;
            }
            copy($file, $dest);
            $this->line("  <info>✓</info> {$dest}");
        }
    }
}
