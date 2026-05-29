<?php

namespace ColorlibHQ\AdminLte\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeAuthCommand extends Command
{
    protected $signature = 'adminlte:make-auth
                            {--type=plain : Auth type (plain, breeze, fortify)}
                            {--force : Overwrite existing files}';

    protected $description = 'Scaffold AdminLTE auth controllers and routes';

    /**
     * Auth controllers published in "plain" mode.
     *
     * @var array<int, string>
     */
    protected array $controllers = [
        'LoginController',
        'RegisterController',
        'ForgotPasswordController',
        'ResetPasswordController',
    ];

    public function handle(): int
    {
        $typeOption = $this->option('type');
        $type = is_string($typeOption) ? $typeOption : 'plain';
        $force = (bool) $this->option('force');

        return match ($type) {
            'plain' => $this->scaffoldPlainAuth($force),
            'breeze' => $this->scaffoldBreeze(),
            'fortify' => $this->scaffoldFortify(),
            default => $this->fail("Invalid auth type: {$type}. Use plain, breeze, or fortify."),
        };
    }

    protected function scaffoldPlainAuth(bool $force): int
    {
        $this->components->info('Scaffolding plain AdminLTE authentication');

        foreach ($this->controllers as $controller) {
            $this->publishFile(
                "stubs/auth-controllers/{$controller}.php.stub",
                app_path("Http/Controllers/Auth/{$controller}.php"),
                $force
            );
        }

        $this->appendAuthRoutes();

        $this->newLine();
        $this->components->info('Plain auth scaffolded. Next steps:');
        $this->line('  1. Auth views ship with the package (adminlte::auth.*) — already wired.');
        $this->line('  2. Ensure your User model and the password_reset_tokens table exist.');
        $this->line('  3. Visit <fg=yellow>/login</> to sign in.');

        return self::SUCCESS;
    }

    protected function scaffoldBreeze(): int
    {
        $this->components->info('Laravel Breeze integration');
        $this->line('  1. Install Breeze: <fg=yellow>composer require laravel/breeze --dev && php artisan breeze:install blade</>');
        $this->line('  2. Re-run <fg=yellow>php artisan adminlte:install --only=views</> to use AdminLTE auth views.');
        $this->line('  3. Breeze routes already cover login/register/password — no extra routes needed.');

        return self::SUCCESS;
    }

    protected function scaffoldFortify(): int
    {
        $this->components->info('Laravel Fortify integration');
        $this->line('  1. Install Fortify: <fg=yellow>composer require laravel/fortify</>');
        $this->line('  2. In FortifyServiceProvider, point the views at AdminLTE:');
        $this->line('     <fg=yellow>Fortify::loginView(fn () => view(\'adminlte::auth.login\'));</>');
        $this->line('     <fg=yellow>Fortify::registerView(fn () => view(\'adminlte::auth.register\'));</>');

        return self::SUCCESS;
    }

    /**
     * Append the auth route group into routes/web.php (idempotent).
     */
    protected function appendAuthRoutes(): void
    {
        $webRoutes = base_path('routes/web.php');

        if (! File::exists($webRoutes)) {
            $this->warn('  routes/web.php not found — skipping route registration.');

            return;
        }

        $contents = (string) File::get($webRoutes);

        if (str_contains($contents, 'AdminLTE authentication routes')) {
            $this->line('  <comment>auth routes already present</comment>');

            return;
        }

        $snippet = (string) File::get(__DIR__.'/../../resources/stubs/routes/auth.php.stub');
        File::append($webRoutes, "\n".$snippet);

        $this->line('  <info>✓</info> auth routes registered in routes/web.php');
    }

    protected function publishFile(string $stub, string $path, bool $force): void
    {
        if (File::exists($path) && ! $force) {
            $this->line("  <comment>exists</comment> {$path}");

            return;
        }

        $stubPath = __DIR__.'/../../resources/'.$stub;
        File::ensureDirectoryExists(dirname($path));
        File::copy($stubPath, $path);
        $this->line("  <info>✓</info> {$path}");
    }
}
