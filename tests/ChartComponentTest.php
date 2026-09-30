<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use ColorlibHQ\AdminLte\View\Components\Tool\Chart;

class ChartComponentTest extends TestCase
{
    public function test_renders_a_canvas_with_a_chartjs_config_and_enables_the_plugin(): void
    {
        $html = (string) $this->blade(
            '<x-adminlte-chart id="sales" type="bar" height="320px"
                :series="[[\'name\' => \'Sales\', \'data\' => [30, 40, 35, 50]]]"
                :categories="[\'Q1\', \'Q2\', \'Q3\', \'Q4\']" />'
        );

        $this->assertStringContainsString('<canvas id="sales"', $html);
        $this->assertMatchesRegularExpression('/data-adminlte-chart\s/', $html);
        $this->assertStringContainsString('height: 320px', $html);
        $this->assertTrue(app(PluginManager::class)->isEnabled('chartjs'));

        preg_match('/data-adminlte-chart-config="([^"]*)"/', $html, $m);
        $config = json_decode(html_entity_decode($m[1]), true);

        $this->assertSame('bar', $config['type']);
        $this->assertSame(['Q1', 'Q2', 'Q3', 'Q4'], $config['data']['labels']);
        $this->assertSame([['label' => 'Sales', 'data' => [30, 40, 35, 50]]], $config['data']['datasets']);
    }

    public function test_plugin_scripts_load_chartjs_then_the_preset(): void
    {
        $this->blade('<x-adminlte-chart :series="[1, 2]" />');

        $scripts = app(PluginManager::class)->renderScripts();

        $this->assertMatchesRegularExpression(
            '#vendor/chartjs/chart\.umd\.min\.js.*\R.*vendor/adminlte/js/charts\.js#',
            $scripts
        );
    }

    public function test_area_becomes_a_filled_line_starting_at_zero(): void
    {
        $config = (new Chart(type: 'area', series: [
            ['name' => 'A', 'data' => [1, 2]],
            ['name' => 'B', 'data' => [3, 4]],
        ], categories: ['x', 'y']))->config();

        $this->assertSame('line', $config['type']);
        $this->assertSame('origin', $config['data']['datasets'][0]['fill']);
        $this->assertTrue($config['options']['scales']['y']['beginAtZero']);
        // Two series keep their legend; one series hides it (the 1.x behaviour).
        $this->assertArrayNotHasKey('display', $config['options']['plugins']['legend'] ?? []);
    }

    public function test_donut_takes_a_flat_series_and_legacy_labels_and_colors(): void
    {
        $config = (new Chart(type: 'donut', series: [44, 55, 13], options: [
            'labels' => ['Apple', 'Mango', 'Orange'],
            'colors' => ['#f00', '#0f0', '#00f'],
            'dataLabels' => ['enabled' => false],
        ]))->config();

        $this->assertSame('doughnut', $config['type']);
        $this->assertSame(['Apple', 'Mango', 'Orange'], $config['data']['labels']);
        $this->assertSame([44, 55, 13], $config['data']['datasets'][0]['data']);
        $this->assertSame(['#f00', '#0f0', '#00f'], $config['data']['datasets'][0]['backgroundColor']);
        $this->assertSame('right', $config['options']['plugins']['legend']['position']);
        $this->assertArrayNotHasKey('dataLabels', $config['options']);
        $this->assertArrayNotHasKey('labels', $config['options']);
    }

    public function test_legacy_options_are_translated(): void
    {
        $config = (new Chart(type: 'bar', series: [
            ['name' => 'Done', 'data' => [1, 2]],
            ['name' => 'Open', 'data' => [3, 4], 'color' => 'var(--bs-danger)'],
        ], categories: ['a', 'b'], options: [
            'chart' => ['stacked' => true, 'toolbar' => ['show' => false]],
            'plotOptions' => ['bar' => ['horizontal' => true]],
            'colors' => ['#111'],
            'legend' => ['show' => false],
            'yaxis' => ['max' => 10],
        ]))->config();

        $this->assertSame('y', $config['options']['indexAxis']);
        $this->assertTrue($config['options']['scales']['x']['stacked']);
        $this->assertTrue($config['options']['scales']['y']['stacked']);
        $this->assertSame(10, $config['options']['scales']['x']['max']);
        $this->assertFalse($config['options']['plugins']['legend']['display']);
        $this->assertSame('#111', $config['data']['datasets'][0]['backgroundColor']);
        $this->assertSame('var(--bs-danger)', $config['data']['datasets'][1]['backgroundColor']);
        $this->assertArrayNotHasKey('chart', $config['options']);
    }

    public function test_stroke_and_sparkline(): void
    {
        $config = (new Chart(type: 'line', series: [['data' => [4, 8, 6]]], options: [
            'chart' => ['sparkline' => ['enabled' => true]],
            'stroke' => ['curve' => 'straight', 'width' => 3],
        ]))->config();

        $this->assertSame(0, $config['data']['datasets'][0]['tension']);
        $this->assertSame(3, $config['data']['datasets'][0]['borderWidth']);
        $this->assertFalse($config['options']['scales']['x']['display']);
        $this->assertFalse($config['options']['plugins']['tooltip']['enabled']);
        // Without categories the points still get (blank) labels, or nothing is drawn.
        $this->assertSame(['', '', ''], $config['data']['labels']);
    }

    public function test_chartjs_options_pass_through_and_win(): void
    {
        $config = (new Chart(type: 'line', series: [['name' => 'A', 'data' => [1], 'borderDash' => [4, 4]]], options: [
            'plugins' => ['legend' => ['display' => true, 'position' => 'top']],
            'scales' => ['y' => ['beginAtZero' => true]],
            'responsive' => ['breakpoint' => 480],
        ]))->config();

        $this->assertTrue($config['options']['plugins']['legend']['display']);
        $this->assertSame('top', $config['options']['plugins']['legend']['position']);
        $this->assertTrue($config['options']['scales']['y']['beginAtZero']);
        $this->assertSame([4, 4], $config['data']['datasets'][0]['borderDash']);
        $this->assertArrayNotHasKey('responsive', $config['options']);
    }

    public function test_empty_options_encode_as_a_json_object(): void
    {
        $json = (new Chart(type: 'scatter', series: [
            ['name' => 'A', 'data' => [['x' => 1, 'y' => 2]]],
            ['name' => 'B', 'data' => [['x' => 2, 'y' => 3]]],
        ]))->chartConfig();

        $this->assertStringContainsString('"options":{}', $json);
    }

    public function test_native_legend_position_beats_the_pie_default(): void
    {
        $config = (new Chart(type: 'pie', series: [1, 2], categories: ['a', 'b'], options: [
            'plugins' => ['legend' => ['position' => 'bottom']],
        ]))->config();

        $this->assertSame('bottom', $config['options']['plugins']['legend']['position']);
    }

    public function test_mixed_series_types(): void
    {
        $config = (new Chart(type: 'bar', series: [
            ['name' => 'Revenue', 'data' => [1, 2]],
            ['name' => 'Trend', 'type' => 'line', 'data' => [1, 2]],
        ], categories: ['a', 'b']))->config();

        $this->assertArrayNotHasKey('type', $config['data']['datasets'][0]);
        $this->assertSame('line', $config['data']['datasets'][1]['type']);
    }
}
