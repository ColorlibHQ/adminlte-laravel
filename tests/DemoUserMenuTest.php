<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Http\Middleware\DemoUserMenu;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DemoUserMenuTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        // Drop `auth` so the demo pages are reachable without a login flow.
        $app['config']->set('adminlte.demo_middleware', ['web']);
        // The `web` group encrypts cookies, which needs a key.
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_the_demo_pages_show_the_full_user_dropdown(): void
    {
        $user = new User;
        $user->forceFill(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

        $response = $this->actingAs($user)->get('demo/ui/icons');

        $response->assertOk();
        // The coloured header block with the 90px avatar — the AdminLTE showcase look.
        $response->assertSee('user-header text-bg-primary', false);
        $response->assertSee('width="90"', false);
    }

    public function test_a_fresh_install_still_gets_the_plain_dropdown(): void
    {
        // The demo override must not leak into the shipped defaults.
        $this->assertFalse(config('adminlte.usermenu_header'));
        $this->assertFalse(config('adminlte.usermenu_image'));
        $this->assertFalse(config('adminlte.usermenu_desc'));

        $user = new User;
        $user->forceFill(['name' => 'Jane Doe']);

        $this->actingAs($user);

        $this->assertStringNotContainsString(
            'user-header',
            view('adminlte::partials.usermenu')->render()
        );
    }

    public function test_the_middleware_leaves_the_profile_url_alone(): void
    {
        // Nothing serves a profile page until `adminlte:scaffold profile` runs,
        // so the showcase must not link to one.
        (new DemoUserMenu)->handle(Request::create('/demo/ui/icons'), fn () => response(''));

        $this->assertFalse(config('adminlte.usermenu_profile_url'));
    }

    public function test_the_demo_routes_carry_the_middleware(): void
    {
        $route = Route::getRoutes()->getByName('adminlte.demo.ui.icons');

        $this->assertNotNull($route);
        $this->assertContains(DemoUserMenu::class, $route->gatherMiddleware());
    }
}
