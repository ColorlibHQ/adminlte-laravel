<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Console\MakeAuthCommand;
use Illuminate\Contracts\Console\Kernel;
use ReflectionClass;

class MakeAuthCommandTest extends TestCase
{
    private string $stubsPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stubsPath = dirname(__DIR__).'/resources/stubs';
    }

    public function test_make_auth_command_is_registered(): void
    {
        $commands = $this->app[Kernel::class]->all();

        $this->assertArrayHasKey('adminlte:make-auth', $commands);
    }

    /**
     * Every controller the command publishes in plain mode must have a stub,
     * including the hardening controllers (email verification, password confirm).
     */
    public function test_all_auth_controller_stubs_exist(): void
    {
        $command = new MakeAuthCommand;
        $property = (new ReflectionClass($command))->getProperty('controllers');
        $property->setAccessible(true);

        /** @var array<int, string> $controllers */
        $controllers = $property->getValue($command);

        $this->assertContains('EmailVerificationController', $controllers);
        $this->assertContains('ConfirmablePasswordController', $controllers);

        foreach ($controllers as $controller) {
            $this->assertFileExists(
                "{$this->stubsPath}/auth-controllers/{$controller}.php.stub",
                "Missing auth controller stub: {$controller}"
            );
        }
    }

    public function test_auth_routes_stub_registers_hardening_routes(): void
    {
        $routes = (string) file_get_contents("{$this->stubsPath}/routes/auth.php.stub");

        $this->assertStringContainsString("name('verification.notice')", $routes);
        $this->assertStringContainsString("name('verification.verify')", $routes);
        $this->assertStringContainsString("name('password.confirm')", $routes);
    }

    public function test_hardened_login_controller_uses_rate_limiting(): void
    {
        $login = (string) file_get_contents("{$this->stubsPath}/auth-controllers/LoginController.php.stub");

        $this->assertStringContainsString('RateLimiter', $login);
        $this->assertStringContainsString('auth.throttle', $login);
    }

    public function test_verify_email_and_confirm_password_views_exist(): void
    {
        $views = dirname(__DIR__).'/resources/views/auth';

        $this->assertFileExists("{$views}/verify-email.blade.php");
        $this->assertFileExists("{$views}/confirm-password.blade.php");
    }
}
