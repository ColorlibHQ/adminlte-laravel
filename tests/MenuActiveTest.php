<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\AdminLte;
use Illuminate\Support\Facades\Route;

class MenuActiveTest extends TestCase
{
    /**
     * @param  array<int, array<string, mixed>>  $menu
     * @return array<int, array<string, mixed>>
     */
    private function build(array $menu, string $path): array
    {
        Route::get('dashboard', fn () => '')->name('admin.dashboard');
        Route::get('admin/projects', fn () => '')->name('admin.projects.index');
        Route::get('/', fn () => '')->name('home');

        config()->set('adminlte.menu', $menu);

        // The builder caches its filtered menu per scope, so one build per test.
        $this->app->forgetInstance(AdminLte::class);
        $this->app->forgetInstance('adminlte');

        $this->get($path);

        return app(AdminLte::class)->menu('sidebar');
    }

    public function test_a_url_item_is_active_on_its_own_page(): void
    {
        $menu = [['text' => 'Projects', 'url' => 'admin/projects']];
        $this->assertTrue($this->build($menu, '/admin/projects')[0]['active']);
    }

    public function test_a_url_item_is_active_on_a_child_page(): void
    {
        $menu = [['text' => 'Projects', 'url' => 'admin/projects']];
        $this->assertTrue($this->build($menu, '/admin/projects/4/edit')[0]['active']);
    }

    public function test_a_root_url_item_is_active_at_the_root(): void
    {
        $menu = [['text' => 'Home', 'url' => '/']];
        $this->assertTrue($this->build($menu, '/')[0]['active']);
    }

    public function test_a_route_item_is_active_on_its_own_page(): void
    {
        $menu = [['text' => 'Dashboard', 'route' => 'admin.dashboard']];
        $this->assertTrue($this->build($menu, '/dashboard')[0]['active']);
    }

    public function test_a_route_item_is_active_on_a_child_page(): void
    {
        $menu = [['text' => 'Projects', 'route' => 'admin.projects.index']];
        $this->assertTrue($this->build($menu, '/admin/projects/4/edit')[0]['active']);
    }

    public function test_a_route_item_is_not_active_elsewhere(): void
    {
        $menu = [['text' => 'Dashboard', 'route' => 'admin.dashboard']];
        $this->assertFalse($this->build($menu, '/admin/projects')[0]['active']);
    }

    public function test_a_route_item_with_parameters_is_active(): void
    {
        Route::get('admin/boards/{board}', fn () => '')->name('admin.boards.show');

        $menu = [['text' => 'Board', 'route' => ['admin.boards.show', ['board' => 7]]]];
        $built = $this->build($menu, '/admin/boards/7');

        $this->assertTrue($built[0]['active']);
    }

    public function test_a_placeholder_item_is_never_active(): void
    {
        $menu = [['text' => 'Nowhere', 'url' => '#']];

        $this->assertFalse($this->build($menu, '/dashboard')[0]['active']);
    }

    public function test_a_placeholder_item_is_not_active_at_the_root_either(): void
    {
        // "#" resolves to the app root once it goes through url(); that must not
        // be read as "this item points at /".
        $menu = [['text' => 'Nowhere', 'url' => '#']];

        $this->assertFalse($this->build($menu, '/')[0]['active']);
    }

    public function test_an_external_link_is_never_active(): void
    {
        // The path of an external URL must not be matched against the app's own.
        $menu = [['text' => 'Docs', 'url' => 'https://example.com/dashboard']];

        $this->assertFalse($this->build($menu, '/dashboard')[0]['active']);
    }

    public function test_an_explicit_pattern_still_wins(): void
    {
        $menu = [['text' => 'Projects', 'route' => 'admin.dashboard', 'active' => ['admin/projects*']]];

        $this->assertTrue($this->build($menu, '/admin/projects/9')[0]['active']);
    }

    public function test_an_explicit_pattern_suppresses_the_derived_one(): void
    {
        // The route would otherwise light this up on /dashboard.
        $menu = [['text' => 'Projects', 'route' => 'admin.dashboard', 'active' => ['admin/projects*']]];

        $this->assertFalse($this->build($menu, '/dashboard')[0]['active']);
    }

    public function test_an_explicit_boolean_still_wins(): void
    {
        $menu = [['text' => 'Pinned', 'route' => 'admin.dashboard', 'active' => true]];

        $this->assertTrue($this->build($menu, '/admin/projects')[0]['active']);
    }

    public function test_a_parent_is_active_when_a_route_driven_child_is(): void
    {
        $menu = [[
            'text' => 'Admin',
            'submenu' => [
                ['text' => 'Dashboard', 'route' => 'admin.dashboard'],
                ['text' => 'Projects', 'route' => 'admin.projects.index'],
            ],
        ]];

        $built = $this->build($menu, '/admin/projects');

        $this->assertTrue($built[0]['active'], 'parent');
        $this->assertFalse($built[0]['submenu'][0]['active'], 'dashboard child');
        $this->assertTrue($built[0]['submenu'][1]['active'], 'projects child');
    }

    public function test_a_header_item_is_left_alone(): void
    {
        $menu = [['header' => 'MAIN NAVIGATION']];

        $this->assertFalse($this->build($menu, '/dashboard')[0]['active']);
    }
}
