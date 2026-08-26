<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Console\ScaffoldCommand;
use ColorlibHQ\AdminLte\Tests\Fixtures\Member;
use Illuminate\Contracts\Console\Kernel;
use ReflectionClass;

class ScaffoldCommandTest extends TestCase
{
    private string $stubsPath;

    /**
     * @var array<int, string>
     */
    private array $tempRoots = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->stubsPath = dirname(__DIR__).'/resources/stubs';
    }

    protected function tearDown(): void
    {
        foreach ($this->tempRoots as $root) {
            $this->deleteTree($root);
        }
        $this->tempRoots = [];

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
     * A default app must keep getting exactly what it got before the users table
     * became resolvable — `users`, spelled out, with no placeholder left behind.
     */
    public function test_published_stubs_name_the_conventional_users_table(): void
    {
        $base = $this->scaffoldInto('mailbox');

        $migration = $this->publishedFile($base, 'database/migrations', 'create_adminlte_messages_table');

        $this->assertStringContainsString("constrained('users')", $migration);
        $this->assertStringNotContainsString('{{', $migration);
    }

    public function test_published_stubs_name_a_renamed_users_table(): void
    {
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'eloquent', 'model' => Member::class]);

        $base = $this->scaffoldInto('mailbox');

        $migration = $this->publishedFile($base, 'database/migrations', 'create_adminlte_messages_table');

        // The foreign keys are what break first: `migrate` fails outright when
        // the referenced table does not exist.
        $this->assertStringContainsString("constrained('members')", $migration);
        $this->assertStringNotContainsString("constrained('users')", $migration);

        $request = $this->publishedFile($base, 'app/Http/Requests/AdminLte', 'StoreMessageRequest');
        $this->assertStringContainsString('exists:members,id', $request);
    }

    public function test_the_dashboard_controller_queries_the_renamed_users_table(): void
    {
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'database', 'table' => 'members']);

        $base = $this->scaffoldInto('dashboard');

        $controller = $this->publishedFile($base, 'app/Http/Controllers/AdminLte', 'DashboardController');

        $this->assertStringContainsString("leftJoin('members', 'members.id'", $controller);
        $this->assertStringContainsString("\$this->count('members')", $controller);
        // The stat array key feeds $stats['users'] in the view — it is not a table.
        $this->assertStringContainsString("'users' => \$this->count('members')", $controller);
    }

    /**
     * Guard against a new stub reintroducing the assumption. Anything naming the
     * table has to go through the placeholder.
     */
    public function test_no_stub_hardcodes_the_users_table(): void
    {
        $offenders = [];

        foreach ($this->stubFiles() as $file) {
            $contents = (string) file_get_contents($file);

            foreach (["constrained('users')", "table('users'", 'unique:users,', 'exists:users,', "'users.id'", "Rule::unique('users'"] as $needle) {
                if (str_contains($contents, $needle)) {
                    $offenders[] = str_replace($this->stubsPath.'/', '', $file)." → {$needle}";
                }
            }
        }

        $this->assertSame([], $offenders, "Use the {{ users_table }} placeholder instead:\n".implode("\n", $offenders));
    }

    /**
     * @return array<int, string>
     */
    private function stubFiles(): array
    {
        $files = [];
        $dir = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->stubsPath));

        foreach ($dir as $file) {
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * Run the command against a throwaway app root and hand back its path.
     */
    private function scaffoldInto(string $section): string
    {
        $base = sys_get_temp_dir().'/adminlte-scaffold-'.bin2hex(random_bytes(6));
        mkdir($base.'/routes', 0755, recursive: true);
        file_put_contents($base.'/routes/web.php', "<?php\n");

        $this->tempRoots[] = $base;
        $this->app->setBasePath($base);

        $this->artisan('adminlte:scaffold', ['section' => $section])->assertSuccessful()->run();

        return $base;
    }

    /**
     * Published migrations carry a generated timestamp prefix, so match on the
     * stem rather than the full name.
     */
    private function publishedFile(string $base, string $dir, string $stem): string
    {
        $matches = glob("{$base}/{$dir}/*{$stem}*") ?: [];

        $this->assertNotEmpty($matches, "Nothing published matching {$dir}/*{$stem}*");

        return (string) file_get_contents($matches[0]);
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
