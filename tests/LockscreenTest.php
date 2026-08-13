<?php

namespace ColorlibHQ\AdminLte\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;

class LockscreenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    private function render(): string
    {
        return view('adminlte::auth.lockscreen')->withErrors([])->render();
    }

    private function actAsUser(): void
    {
        $user = new User;
        $user->forceFill(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

        $this->actingAs($user);
    }

    public function test_it_carries_the_body_class_adminlte_styles_the_page_with(): void
    {
        // Every .lockscreen-* rule in AdminLTE is scoped under `.lockscreen`.
        // Without it the whole page renders unstyled.
        $this->actAsUser();

        $html = $this->render();

        $this->assertStringContainsString('class="lockscreen', $html);
        $this->assertStringContainsString('lockscreen-wrapper', $html);
        $this->assertStringContainsString('lockscreen-credentials', $html);
    }

    public function test_it_shows_the_authenticated_user(): void
    {
        $this->actAsUser();

        $html = $this->render();

        $this->assertStringContainsString('<div class="lockscreen-name">Jane Doe</div>', $html);
        $this->assertStringContainsString('alt="Jane Doe"', $html);
    }

    public function test_it_renders_for_a_guest_without_erroring(): void
    {
        $html = $this->render();

        $this->assertStringContainsString('Guest', $html);
    }

    public function test_it_posts_to_the_named_confirm_route_when_registered(): void
    {
        Route::get('confirm-password', fn () => '')->name('password.confirm');

        $this->actAsUser();

        $this->assertStringContainsString('action="'.route('password.confirm').'"', $this->render());
    }

    public function test_it_falls_back_to_a_path_when_auth_is_not_scaffolded(): void
    {
        $this->actAsUser();

        // No `password.confirm` route — must not throw RouteNotFoundException.
        $this->assertStringContainsString('action="'.url('confirm-password').'"', $this->render());
    }

    public function test_the_logo_links_to_the_app_root(): void
    {
        $this->actAsUser();

        $html = $this->render();

        $this->assertStringContainsString('href="'.url('/').'"', $html);
        $this->assertStringNotContainsString('index2.html', $html);
    }

    public function test_the_sign_in_link_is_omitted_without_a_login_route(): void
    {
        $this->actAsUser();

        $this->assertStringNotContainsString(__('adminlte.sign_in_as_different_user'), $this->render());
    }

    public function test_the_sign_in_link_is_shown_when_a_login_route_exists(): void
    {
        Route::get('login', fn () => '')->name('login');

        $this->actAsUser();

        $this->assertStringContainsString(__('adminlte.sign_in_as_different_user'), $this->render());
    }
}
