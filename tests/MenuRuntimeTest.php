<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\AdminLte;

class MenuRuntimeTest extends TestCase
{
    private function freshMenu(array $menu): AdminLte
    {
        config()->set('adminlte.menu', $menu);
        app()->forgetInstance(AdminLte::class);

        return app('adminlte');
    }

    public function test_add_after_inserts_after_matching_text(): void
    {
        $adminlte = $this->freshMenu([
            ['text' => 'Dashboard', 'url' => '/'],
            ['text' => 'Settings', 'url' => 'settings'],
        ]);

        $adminlte->addAfter('Dashboard', ['text' => 'Reports', 'url' => 'reports']);

        $texts = array_column($adminlte->menu('sidebar'), 'text');
        $this->assertSame(['Dashboard', 'Reports', 'Settings'], $texts);
    }

    public function test_add_after_inserts_after_matching_key_attribute(): void
    {
        $adminlte = $this->freshMenu([
            ['text' => 'Dashboard', 'url' => '/', 'key' => 'dash'],
            ['text' => 'Settings', 'url' => 'settings'],
        ]);

        $adminlte->addAfter('dash', ['text' => 'Reports', 'url' => 'reports']);

        $texts = array_column($adminlte->menu('sidebar'), 'text');
        $this->assertSame(['Dashboard', 'Reports', 'Settings'], $texts);
    }

    public function test_add_after_inserts_after_matching_header(): void
    {
        $adminlte = $this->freshMenu([
            ['header' => 'MAIN'],
            ['text' => 'Dashboard', 'url' => '/'],
        ]);

        $adminlte->addAfter('MAIN', ['text' => 'First', 'url' => 'first']);

        $items = $adminlte->menu('sidebar');
        $this->assertSame('MAIN', $items[0]['header']);
        $this->assertSame('First', $items[1]['text']);
        $this->assertSame('Dashboard', $items[2]['text']);
    }

    public function test_add_after_appends_when_key_not_found(): void
    {
        $adminlte = $this->freshMenu([
            ['text' => 'Dashboard', 'url' => '/'],
        ]);

        $adminlte->addAfter('nope', ['text' => 'Tail', 'url' => 'tail']);

        $texts = array_column($adminlte->menu('sidebar'), 'text');
        $this->assertSame(['Dashboard', 'Tail'], $texts);
    }

    public function test_add_appends_to_end(): void
    {
        $adminlte = $this->freshMenu([
            ['text' => 'Dashboard', 'url' => '/'],
        ]);

        $adminlte->add(
            ['text' => 'One', 'url' => 'one'],
            ['text' => 'Two', 'url' => 'two'],
        );

        $texts = array_column($adminlte->menu('sidebar'), 'text');
        $this->assertSame(['Dashboard', 'One', 'Two'], $texts);
    }

    public function test_runtime_additions_invalidate_the_filtered_cache(): void
    {
        $adminlte = $this->freshMenu([
            ['text' => 'Dashboard', 'url' => '/'],
        ]);

        // Build (and cache) the filtered menu, then mutate.
        $this->assertCount(1, $adminlte->menu('sidebar'));
        $adminlte->add(['text' => 'Later', 'url' => 'later']);

        $this->assertCount(2, $adminlte->menu('sidebar'));
    }

    public function test_submenu_items_resolve_hrefs_and_active_state(): void
    {
        $adminlte = $this->freshMenu([
            [
                'text' => 'Admin',
                'icon' => 'bi bi-gear',
                'submenu' => [
                    ['text' => 'Users', 'url' => 'admin/users'],
                    ['text' => 'Roles', 'url' => 'admin/roles'],
                ],
            ],
        ]);

        $sidebar = $adminlte->menu('sidebar');

        $this->assertSame(url('admin/users'), $sidebar[0]['submenu'][0]['href']);
    }

    public function test_menu_item_without_text_or_header_is_dropped(): void
    {
        $adminlte = $this->freshMenu([
            ['url' => 'orphan'],
            ['text' => 'Kept', 'url' => 'kept'],
        ]);

        $texts = array_column($adminlte->menu('sidebar'), 'text');
        $this->assertSame(['Kept'], $texts);
    }
}
