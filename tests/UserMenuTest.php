<?php

namespace ColorlibHQ\AdminLte\Tests;

use Illuminate\Foundation\Auth\User;

class UserMenuTest extends TestCase
{
    private function actAsUser(): void
    {
        $user = new User;
        $user->forceFill([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            // The "member since" line only renders for a user that has one.
            'created_at' => now()->setDate(2024, 3, 1),
        ]);

        $this->actingAs($user);
    }

    private function render(): string
    {
        $this->actAsUser();

        return view('adminlte::partials.usermenu')->render();
    }

    public function test_header_is_hidden_unless_usermenu_header_is_enabled(): void
    {
        $this->assertStringNotContainsString('user-header', $this->render());
    }

    public function test_header_uses_the_configured_class(): void
    {
        config()->set('adminlte.usermenu_header', true);
        config()->set('adminlte.usermenu_header_class', 'text-bg-dark');

        $this->assertStringContainsString('user-header text-bg-dark', $this->render());
    }

    public function test_header_collapses_its_reserved_height_when_the_avatar_is_hidden(): void
    {
        // AdminLTE reserves 175px on .user-header for the 90px avatar; with no
        // avatar that leaves a large empty block.
        config()->set('adminlte.usermenu_header', true);
        config()->set('adminlte.usermenu_image', false);

        $html = $this->render();

        $this->assertStringContainsString('min-height: 0', $html);
        $this->assertStringNotContainsString('width="90"', $html);
    }

    public function test_header_keeps_its_reserved_height_when_the_avatar_is_shown(): void
    {
        config()->set('adminlte.usermenu_header', true);
        config()->set('adminlte.usermenu_image', true);

        $html = $this->render();

        $this->assertStringNotContainsString('min-height: 0', $html);
        $this->assertStringContainsString('width="90"', $html);
    }

    public function test_member_since_is_shown_only_when_usermenu_desc_is_enabled(): void
    {
        config()->set('adminlte.usermenu_header', true);
        config()->set('adminlte.usermenu_desc', false);
        $this->assertStringNotContainsString('<small>', $this->render());

        config()->set('adminlte.usermenu_desc', true);
        $html = $this->render();
        $this->assertStringContainsString('<small>', $html);
        $this->assertStringContainsString('Mar. 2024', $html);
    }

    public function test_profile_link_is_hidden_when_profile_url_is_false(): void
    {
        // The docs have always said `false` hides the link; it used to fall
        // back to /admin/profile instead.
        $html = $this->render();

        $this->assertStringNotContainsString(__('adminlte.profile'), $html);
        $this->assertStringContainsString('btn btn-outline-danger w-100', $html);
    }

    public function test_profile_link_is_absolute_when_a_path_is_configured(): void
    {
        config()->set('adminlte.usermenu_profile_url', 'profile');

        $html = $this->render();

        // Must go through url() — a bare "profile" href resolves relative to
        // the current page (/admin/users/5 → /admin/users/profile).
        $this->assertStringContainsString('href="'.url('profile').'"', $html);
        $this->assertStringContainsString('btn btn-outline-danger float-end', $html);
    }

    public function test_profile_link_accepts_an_absolute_url(): void
    {
        config()->set('adminlte.usermenu_profile_url', 'https://accounts.example.com/me');

        $this->assertStringContainsString(
            'href="https://accounts.example.com/me"',
            $this->render()
        );
    }
}
