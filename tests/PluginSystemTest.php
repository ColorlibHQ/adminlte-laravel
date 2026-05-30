<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Plugins\PluginManager;

class PluginSystemTest extends TestCase
{
    public function test_plugin_manager_can_enable_plugin(): void
    {
        $plugins = app(PluginManager::class);
        $plugins->enable('flatpickr');

        $this->assertTrue($plugins->isEnabled('flatpickr'));
    }

    public function test_plugin_manager_can_disable_plugin(): void
    {
        $plugins = app(PluginManager::class);
        $plugins->enable('flatpickr');
        $plugins->disable('flatpickr');

        $this->assertFalse($plugins->isEnabled('flatpickr'));
    }

    public function test_plugin_manager_returns_css_only_when_enabled(): void
    {
        $plugins = app(PluginManager::class);

        $this->assertNull($plugins->getCss('flatpickr'));

        $plugins->enable('flatpickr');
        $this->assertNotNull($plugins->getCss('flatpickr'));
    }

    public function test_plugin_manager_returns_js_only_when_enabled(): void
    {
        $plugins = app(PluginManager::class);

        $this->assertNull($plugins->getJs('flatpickr'));

        $plugins->enable('flatpickr');
        $this->assertNotNull($plugins->getJs('flatpickr'));
    }

    public function test_fullcalendar_css_default_fills_missing_config_key(): void
    {
        // Simulates an app whose published config omits the FullCalendar css key
        // (FC v6 embeds CSS in its JS but doesn't inject it inside the AdminLTE
        // page, so the stylesheet must be served explicitly). The manager's
        // defaults must patch it in.
        $plugins = new PluginManager([
            'fullcalendar' => ['enabled' => true, 'js' => 'vendor/fullcalendar/index.global.min.js'],
        ]);

        $this->assertSame('vendor/fullcalendar/index.global.min.css', $plugins->getCss('fullcalendar'));
        $this->assertStringContainsString('fullcalendar/index.global.min.css', $plugins->renderStyles());
    }

    public function test_app_config_overrides_plugin_defaults(): void
    {
        $plugins = new PluginManager([
            'fullcalendar' => ['enabled' => true, 'css' => 'custom/my-fc.css'],
        ]);

        $this->assertSame('custom/my-fc.css', $plugins->getCss('fullcalendar'));
    }

    public function test_plugin_manager_respects_config_enabled(): void
    {
        config()->set('adminlte.plugins.flatpickr.enabled', true);
        app()->forgetInstance(PluginManager::class);

        $plugins = app(PluginManager::class);

        $this->assertTrue($plugins->isEnabled('flatpickr'));
    }
}
