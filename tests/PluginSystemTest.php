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

    public function test_plugin_manager_respects_config_enabled(): void
    {
        config()->set('adminlte.plugins.flatpickr.enabled', true);
        app()->forgetInstance(PluginManager::class);

        $plugins = app(PluginManager::class);

        $this->assertTrue($plugins->isEnabled('flatpickr'));
    }
}
