<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Console\MakeAuthCommand;
use ColorlibHQ\AdminLte\Tests\Fixtures\Member;
use Illuminate\Contracts\Console\Kernel;
use ReflectionClass;

class MakeAuthCommandTest extends TestCase
{
    private string $stubsPath;

    private ?string $tempRoot = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stubsPath = dirname(__DIR__).'/resources/stubs';
    }

    protected function tearDown(): void
    {
        if ($this->tempRoot !== null) {
            $this->deleteTree($this->tempRoot);
            $this->tempRoot = null;
        }

        parent::tearDown();
    }

    private function deleteTree(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        foreach (scandir($path) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $child = $path.'/'.$entry;
            is_dir($child) ? $this->deleteTree($child) : unlink($child);
        }

        rmdir($path);
    }

    /**
     * The registration rules validate uniqueness against the users table by
     * name, so it has to be the app's real one.
     */
    public function test_the_register_controller_validates_against_the_real_users_table(): void
    {
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'eloquent', 'model' => Member::class]);

        $base = sys_get_temp_dir().'/adminlte-auth-'.bin2hex(random_bytes(6));
        mkdir($base.'/routes', 0755, recursive: true);
        file_put_contents($base.'/routes/web.php', "<?php\n");
        $this->tempRoot = $base;
        $this->app->setBasePath($base);

        $this->artisan('adminlte:make-auth')->assertSuccessful()->run();

        $controller = (string) file_get_contents($base.'/app/Http/Controllers/Auth/RegisterController.php');

        $this->assertStringContainsString('unique:members,email', $controller);
        $this->assertStringNotContainsString('{{', $controller);
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
