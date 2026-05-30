<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Console\ScaffoldCommand;
use Illuminate\Contracts\Console\Kernel;
use ReflectionClass;

class ScaffoldCommandTest extends TestCase
{
    private string $stubsPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stubsPath = dirname(__DIR__).'/resources/stubs';
    }

    public function test_scaffold_command_is_registered(): void
    {
        $commands = $this->app[Kernel::class]->all();

        $this->assertArrayHasKey('adminlte:scaffold', $commands);
    }

    /**
     * Every migration / model / controller / seeder / route stub referenced by
     * the command's manifest must exist on disk, or scaffolding will fail.
     */
    public function test_all_manifest_stubs_exist(): void
    {
        $manifest = $this->manifest();

        foreach ($manifest as $section => $spec) {
            foreach ((array) ($spec['migrations'] ?? []) as $migration) {
                $this->assertFileExists("{$this->stubsPath}/migrations/{$migration}.php.stub", "[$section] migration");
            }
            foreach ((array) ($spec['models'] ?? []) as $model) {
                $this->assertFileExists("{$this->stubsPath}/models/{$model}.php.stub", "[$section] model");
            }
            foreach ((array) ($spec['controllers'] ?? []) as $controller) {
                $this->assertFileExists("{$this->stubsPath}/controllers/{$controller}.php.stub", "[$section] controller");
            }
            foreach ((array) ($spec['seeders'] ?? []) as $seeder) {
                $this->assertFileExists("{$this->stubsPath}/seeders/{$seeder}.php.stub", "[$section] seeder");
            }
            foreach ((array) ($spec['factories'] ?? []) as $factory) {
                $this->assertFileExists("{$this->stubsPath}/factories/{$factory}.php.stub", "[$section] factory");
            }
            foreach ((array) ($spec['requests'] ?? []) as $request) {
                $this->assertFileExists("{$this->stubsPath}/requests/{$request}.php.stub", "[$section] request");
            }
            foreach ((array) ($spec['policies'] ?? []) as $policy) {
                $this->assertFileExists("{$this->stubsPath}/policies/{$policy}.php.stub", "[$section] policy");
            }
            foreach ((array) ($spec['tests'] ?? []) as $test) {
                $this->assertFileExists("{$this->stubsPath}/tests/{$test}.php.stub", "[$section] test");
            }
            foreach ((array) ($spec['notifications'] ?? []) as $notification) {
                $this->assertFileExists("{$this->stubsPath}/notifications/{$notification}.php.stub", "[$section] notification");
            }
            foreach ((array) ($spec['concerns'] ?? []) as $concern) {
                $this->assertFileExists("{$this->stubsPath}/concerns/{$concern}.php.stub", "[$section] concern");
            }
            if (! empty($spec['routes'])) {
                $this->assertFileExists("{$this->stubsPath}/routes/{$spec['routes']}.php.stub", "[$section] routes");
            }
            if (! empty($spec['views'])) {
                $this->assertDirectoryExists("{$this->stubsPath}/views/{$spec['views']}", "[$section] views");
            }
        }
    }

    public function test_realtime_stubs_exist(): void
    {
        $this->assertFileExists("{$this->stubsPath}/events/NewChatMessage.php.stub");
        $this->assertFileExists("{$this->stubsPath}/realtime/adminlte-realtime.js.stub");
        $this->assertFileExists("{$this->stubsPath}/realtime/channels.php.stub");
    }

    public function test_every_content_section_has_a_view(): void
    {
        $viewless = [
            'rbac',          // publishes its own users/ and roles/ view dirs via scaffoldRbac().
            'impersonation', // controller + routes only; banner lives in the package.
        ];

        foreach ($this->manifest() as $section => $spec) {
            if (in_array($section, $viewless, true)) {
                continue;
            }
            $this->assertNotEmpty($spec['views'] ?? null, "Section '$section' must define a views directory.");
        }
    }

    /**
     * Read the protected $manifest property off the command for assertions.
     *
     * @return array<string, array<string, mixed>>
     */
    private function manifest(): array
    {
        $command = new ScaffoldCommand;
        $property = (new ReflectionClass($command))->getProperty('manifest');
        $property->setAccessible(true);

        /** @var array<string, array<string, mixed>> $value */
        $value = $property->getValue($command);

        return $value;
    }
}
