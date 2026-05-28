<?php

namespace ColorlibHQ\AdminLte\Tests;

class ConsoleCommandTest extends TestCase
{
    public function test_install_command_exists(): void
    {
        $this->artisan('adminlte:install')
            ->expectsOutput('AdminLTE 4 has been installed')
            ->assertExitCode(0);
    }

    public function test_status_command_shows_information(): void
    {
        $this->artisan('adminlte:status')
            ->assertExitCode(0);
    }

    public function test_install_command_publishes_assets(): void
    {
        $this->artisan('adminlte:install');

        $this->assertFileExists(resource_path('js/adminlte.js'));
        $this->assertFileExists(resource_path('css/adminlte.css'));
    }

    public function test_install_command_creates_config(): void
    {
        $this->artisan('adminlte:install');

        $this->assertFileExists(config_path('adminlte.php'));
    }
}
