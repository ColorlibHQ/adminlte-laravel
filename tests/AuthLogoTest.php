<?php

namespace ColorlibHQ\AdminLte\Tests;

use Illuminate\Support\Facades\Route;

class AuthLogoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // auth-master's children link to the named login route.
        Route::get('login', fn () => '')->name('login');
    }

    private function renderLogin(): string
    {
        return view('adminlte::auth.login')->withErrors([])->render();
    }

    public function test_auth_logo_is_absent_by_default(): void
    {
        // `auth_logo.enabled` ships false — the auth pages show the text logo
        // only. Nothing may reference the image path, which no install step
        // publishes.
        $html = $this->renderLogin();

        $this->assertStringNotContainsString('AdminLTELogo.png', $html);
        $this->assertStringContainsString('<b>Admin</b>LTE', $html);
    }

    public function test_auth_logo_renders_when_enabled(): void
    {
        config()->set('adminlte.auth_logo.enabled', true);

        $html = $this->renderLogin();

        $this->assertStringContainsString(asset('vendor/adminlte/img/AdminLTELogo.png'), $html);
        $this->assertStringContainsString('alt="Auth Logo"', $html);
        $this->assertStringContainsString('width="50"', $html);
        $this->assertStringContainsString('height="50"', $html);
    }

    public function test_auth_logo_honours_img_overrides(): void
    {
        config()->set('adminlte.auth_logo', [
            'enabled' => true,
            'img' => [
                'path' => 'img/brand.svg',
                'alt' => 'Acme',
                'class' => 'rounded me-2',
                'width' => 120,
                'height' => 40,
            ],
        ]);

        $html = $this->renderLogin();

        $this->assertStringContainsString(asset('img/brand.svg'), $html);
        $this->assertStringContainsString('alt="Acme"', $html);
        $this->assertStringContainsString('class="rounded me-2"', $html);
        $this->assertStringContainsString('width="120"', $html);
        $this->assertStringContainsString('height="40"', $html);
    }

    public function test_optional_img_attributes_are_omitted_when_empty(): void
    {
        config()->set('adminlte.auth_logo', [
            'enabled' => true,
            'img' => [
                'path' => 'img/brand.svg',
                'alt' => 'Acme',
                'class' => '',
                'width' => null,
                'height' => null,
            ],
        ]);

        $html = $this->renderLogin();

        // Note: the quoted forms only — the viewport meta carries an unquoted
        // `width=device-width`.
        $this->assertStringNotContainsString('width="', $html);
        $this->assertStringNotContainsString('height="', $html);
        $this->assertStringNotContainsString('class=""', $html);
    }
}
