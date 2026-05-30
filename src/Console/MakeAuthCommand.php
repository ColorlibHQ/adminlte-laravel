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
        'EmailVerificationController',
        'ConfirmablePasswordController',
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
        $this->injectMustVerifyEmail();

        $this->newLine();
        $this->components->info('Plain auth scaffolded. Next steps:');
        $this->line('  1. Auth views ship with the package (adminlte::auth.*) — already wired.');
        $this->line('  2. Ensure your User model and the password_reset_tokens table exist.');
        $this->line('  3. Login is rate-limited; email verification + password confirmation routes are registered.');
        $this->line('  4. Add the <fg=yellow>verified</> middleware to routes that should require a verified email.');
        $this->line('  5. Visit <fg=yellow>/login</> to sign in.');

        return self::SUCCESS;
    }

    /**
     * Make the app's User model implement MustVerifyEmail (idempotent), so the
     * verified middleware and verification notifications work out of the box.
     */
    protected function injectMustVerifyEmail(): void
    {
        $userModel = app_path('Models/User.php');

        if (! File::exists($userModel)) {
            $this->warn('  app/Models/User.php not found — implement MustVerifyEmail manually.');

            return;
        }

        $contents = (string) File::get($userModel);

        // Already implemented? (Match the `implements` clause, not the commented
        // import that ships in Laravel's default User model.)
        if (preg_match('/class User extends \w+[^{]*\bimplements\b[^{]*MustVerifyEmail/s', $contents)) {
            $this->line('  <comment>User model already implements MustVerifyEmail</comment>');

            return;
        }

        if (str_contains($contents, '// use Illuminate\Contracts\Auth\MustVerifyEmail;')) {
            // Uncomment the import Laravel ships commented-out by default.
            $contents = str_replace(
                '// use Illuminate\Contracts\Auth\MustVerifyEmail;',
                'use Illuminate\Contracts\Auth\MustVerifyEmail;',
                $contents
            );
        } elseif (! str_contains($contents, 'use Illuminate\Contracts\Auth\MustVerifyEmail;')) {
            // Otherwise import the contract after the namespace declaration.
            $contents = (string) preg_replace(
                '/^(namespace App\\\\Models;\s*)$/m',
                "$1\nuse Illuminate\\Contracts\\Auth\\MustVerifyEmail;",
                $contents,
                1
            );
        }

        // Add the interface to the class signature.
        if (preg_match('/class User extends \w+ implements /', $contents)) {
            $contents = (string) preg_replace(
                '/(class User extends \w+ implements )/',
                '$1MustVerifyEmail, ',
                $contents,
                1
            );
        } else {
            $contents = (string) preg_replace(
                '/(class User extends \w+)/',
                '$1 implements MustVerifyEmail',
                $contents,
                1
            );
        }

        File::put($userModel, $contents);
        $this->line('  <info>✓</info> User model now implements MustVerifyEmail');
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
