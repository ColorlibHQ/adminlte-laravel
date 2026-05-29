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
            if (! empty($spec['routes'])) {
                $this->assertFileExists("{$this->stubsPath}/routes/{$spec['routes']}.php.stub", "[$section] routes");
            }
            if (! empty($spec['views'])) {
                $this->assertDirectoryExists("{$this->stubsPath}/views/{$spec['views']}", "[$section] views");
            }
        }
    }

    public function test_every_section_has_a_view(): void
    {
        foreach ($this->manifest() as $section => $spec) {
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
