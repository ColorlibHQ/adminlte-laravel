<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Plugins\PluginManager;

class FormComponentTest extends TestCase
{
    public function test_flatpickr_component_enables_plugin(): void
    {
        $this->blade('<x-adminlte-input-flatpickr name="date" />');

        $plugins = app(PluginManager::class);
        $this->assertTrue($plugins->isEnabled('flatpickr'));
    }

    public function test_tom_select_component_enables_plugin(): void
    {
        $this->blade('<x-adminlte-input-tom-select name="select" :options="[]" />');

        $plugins = app(PluginManager::class);
        $this->assertTrue($plugins->isEnabled('tom_select'));
    }

    public function test_datatable_component_enables_plugin(): void
    {
        $this->blade('<x-adminlte-datatable id="table" :columns="[]" :data="[]" />');

        $plugins = app(PluginManager::class);
        $this->assertTrue($plugins->isEnabled('tabulator'));
    }

    public function test_editor_component_enables_plugin(): void
    {
        $this->blade('<x-adminlte-editor name="content" />');

        $plugins = app(PluginManager::class);
        $this->assertTrue($plugins->isEnabled('quill'));
    }

    public function test_flatpickr_component_renders(): void
    {
        $html = $this->blade(
            '<x-adminlte-input-flatpickr name="birthdate" label="Birth Date" type="date" />'
        );

        $html->assertSee('data-flatpickr', false);
        $html->assertSee('Birth Date');
        $html->assertSee('bi-calendar', false);
    }

    public function test_tom_select_component_renders_options(): void
    {
        $html = $this->blade(
            '<x-adminlte-input-tom-select name="status" label="Status" :options="[\'active\' => \'Active\', \'inactive\' => \'Inactive\']" />'
        );

        $html->assertSee('data-tom-select', false);
        $html->assertSee('Active');
        $html->assertSee('Inactive');
        $html->assertSee('Status');
    }

    public function test_editor_component_renders_hidden_input(): void
    {
        $html = $this->blade(
            '<x-adminlte-editor name="description" label="Description" />'
        );

        $html->assertSee('type="hidden"', false);
        $html->assertSee('name="description"', false);
        $html->assertSee('data-quill', false);
    }
}
