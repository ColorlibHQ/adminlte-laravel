<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\AdminLte;

class SmokeTest extends TestCase
{
    public function test_service_is_bound(): void
    {
        $this->assertInstanceOf(AdminLte::class, app('adminlte'));
    }

    public function test_menu_builds_and_resolves_hrefs(): void
    {
        config()->set('adminlte.menu', [
            ['header' => 'MAIN'],
            ['text' => 'Dashboard', 'url' => '/', 'icon' => 'bi bi-speedometer'],
            ['text' => 'Users', 'url' => 'users', 'icon' => 'bi bi-people'],
        ]);

        // Rebind so the singleton picks up the new config.
        app()->forgetInstance(AdminLte::class);

        $sidebar = app('adminlte')->menu('sidebar');

        $this->assertCount(3, $sidebar);
        $this->assertSame('MAIN', $sidebar[0]['header']);
        $this->assertSame(url('users'), $sidebar[2]['href']);
    }

    public function test_gate_filter_hides_unauthorized_items(): void
    {
        config()->set('adminlte.menu', [
            ['text' => 'Secret', 'url' => 'secret', 'can' => 'do-secret-thing'],
            ['text' => 'Public', 'url' => 'public'],
        ]);
        app()->forgetInstance(AdminLte::class);

        // No gate defined → 'do-secret-thing' denied → item removed.
        $sidebar = app('adminlte')->menu('sidebar');

        $texts = array_column($sidebar, 'text');
        $this->assertContains('Public', $texts);
        $this->assertNotContains('Secret', $texts);
    }

    public function test_card_component_renders(): void
    {
        $html = $this->blade(
            '<x-adminlte-card title="Hello" theme="primary" outline>Body</x-adminlte-card>'
        );

        $html->assertSee('card card-primary card-outline', false);
        $html->assertSee('Hello');
        $html->assertSee('Body');
    }

    public function test_small_box_component_renders(): void
    {
        $html = $this->blade(
            '<x-adminlte-small-box title="150" text="Orders" icon="bi bi-cart" theme="success" url="#" />'
        );

        $html->assertSee('small-box text-bg-success', false);
        $html->assertSee('150');
        $html->assertSee('Orders');
        $html->assertSee('small-box-icon bi bi-cart', false);
    }

    public function test_input_component_shows_label_and_value(): void
    {
        $html = $this->blade(
            '<x-adminlte-input name="email" label="Email" type="email" value="a@b.com" />'
        );

        $html->assertSee('Email');
        $html->assertSee('name="email"', false);
        $html->assertSee('type="email"', false);
        $html->assertSee('a@b.com');
    }

    public function test_modal_component_renders(): void
    {
        $html = $this->blade(
            '<x-adminlte-modal id="confirm" title="Are you sure?" size="lg" centered>Body</x-adminlte-modal>'
        );

        $html->assertSee('id="confirm"', false);
        $html->assertSee('modal-dialog modal-lg modal-dialog-centered', false);
        $html->assertSee('Are you sure?');
        $html->assertSee('Body');
    }
}
