<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * <x-adminlte-chart>, rendered with Chart.js (MIT).
 *
 * The props are the ones the component has always had: `type`, `series`,
 * `categories`, `options`, `id` and `height`. The component turns them into a
 * Chart.js config; the `chartjs` plugin's preset (public/vendor/adminlte/js/charts.js)
 * renders it, themes it and re-themes it when the colour mode changes.
 *
 * `options` takes Chart.js options (`plugins`, `scales`, `indexAxis`, …), deep-merged
 * over the defaults. For configs written against the 1.x component, a handful of the
 * old option keys are still understood — `colors`, `labels`, `chart.stacked`,
 * `chart.sparkline.enabled`, `plotOptions.bar.horizontal`, `legend.show`,
 * `legend.position`, `stroke.curve`, `stroke.width`, `xaxis.categories`,
 * `yaxis.min`/`yaxis.max` — and the rest of those old keys are dropped.
 */
class Chart extends Component
{
    public string $id;

    /**
     * Accepted `type` values, lower-cased, mapped to Chart.js chart types.
     *
     * @var array<string, string>
     */
    private const TYPES = [
        'area' => 'line',
        'line' => 'line',
        'bar' => 'bar',
        'column' => 'bar',
        'pie' => 'pie',
        'donut' => 'doughnut',
        'doughnut' => 'doughnut',
        'radar' => 'radar',
        'polararea' => 'polarArea',
        'scatter' => 'scatter',
        'bubble' => 'bubble',
        'sparkline' => 'line',
    ];

    /** Chart.js types that plot one value per slice instead of x/y series. */
    private const ARC_TYPES = ['pie', 'doughnut', 'polarArea'];

    /**
     * Top-level `options` keys from the 1.x component's config. They are
     * translated where there is a Chart.js equivalent and never passed through.
     */
    private const LEGACY_OPTION_KEYS = [
        'annotations', 'chart', 'colors', 'dataLabels', 'fill', 'grid', 'labels', 'legend',
        'markers', 'noData', 'plotOptions', 'states', 'stroke', 'subtitle', 'theme', 'title',
        'tooltip', 'xaxis', 'yaxis',
    ];

    /** Series keys with no Chart.js dataset equivalent. */
    private const LEGACY_SERIES_KEYS = ['name', 'color', 'group', 'type', 'zIndex'];

    /**
     * @param  array<int|string, mixed>  $series
     * @param  array<int, mixed>  $categories
     * @param  array<string, mixed>  $options
     */
    public function __construct(
        public string $type = 'area',
        public array $series = [],
        public array $categories = [],
        public array $options = [],
        ?string $id = null,
        public string $height = '300px',
    ) {
        $this->id = $id ?? 'chart-'.uniqid();
        app(PluginManager::class)->enable('chartjs');
    }

    /**
     * The Chart.js config for this chart.
     *
     * @return array{type: string, data: array{labels: array<int, mixed>, datasets: array<int, array<string, mixed>>}, options: array<string, mixed>}
     */
    public function config(): array
    {
        $requested = strtolower($this->type);
        $type = self::TYPES[$requested] ?? $this->type;
        $arc = in_array($type, self::ARC_TYPES, true);

        $legacy = array_intersect_key($this->options, array_flip(self::LEGACY_OPTION_KEYS));
        $native = array_diff_key($this->options, $legacy);
        if (isset($native['responsive']) && ! is_bool($native['responsive'])) {
            unset($native['responsive']); // the 1.x breakpoint list, not Chart.js's flag
        }

        $sparkline = $requested === 'sparkline' || data_get($legacy, 'chart.sparkline.enabled') === true;
        $datasets = $this->datasets($type, $requested, $legacy);

        $options = [];

        // One series needs no legend (the 1.x behaviour); slices always do.
        if (data_get($legacy, 'legend.show') === false || (! $arc && count($datasets) < 2)) {
            $options['plugins']['legend']['display'] = false;
        }
        if (is_string($position = data_get($legacy, 'legend.position'))) {
            $options['plugins']['legend']['position'] = $position;
        } elseif ($arc) {
            $options['plugins']['legend']['position'] = 'right'; // as 1.x drew pie/donut legends
        }

        $valueAxis = 'y';
        if ($requested === 'area') {
            $options['scales']['y']['beginAtZero'] = true; // filled areas start at zero
        }
        if (data_get($legacy, 'plotOptions.bar.horizontal') === true) {
            $options['indexAxis'] = 'y';
            $valueAxis = 'x';
        }
        if (data_get($legacy, 'chart.stacked') === true) {
            $options['scales']['x']['stacked'] = true;
            $options['scales']['y']['stacked'] = true;
        }
        foreach (['min', 'max'] as $bound) {
            $value = data_get($legacy, "yaxis.$bound");
            if (is_int($value) || is_float($value)) {
                $options['scales'][$valueAxis][$bound] = $value;
            }
        }

        if ($sparkline) {
            $options = array_replace_recursive($options, [
                'plugins' => ['legend' => ['display' => false], 'tooltip' => ['enabled' => false]],
                'scales' => ['x' => ['display' => false], 'y' => ['display' => false]],
                'elements' => ['point' => ['radius' => 0, 'hoverRadius' => 0]],
                'layout' => ['padding' => 2],
            ]);
        }

        /** @var array<string, mixed> $options */
        $options = array_replace_recursive($options, $native);

        // A category axis draws nothing without labels: number the points.
        $labels = $this->labels($legacy);
        if ($labels === [] && ! $arc && in_array($type, ['line', 'bar', 'radar'], true)) {
            $points = max(0, ...array_map(fn (array $d): int => is_array($d['data'] ?? null) ? count($d['data']) : 0, $datasets));
            if ($points > 0) {
                $labels = $sparkline ? array_fill(0, $points, '') : range(1, $points);
            }
        }

        return [
            'type' => $type,
            'data' => [
                'labels' => $labels,
                'datasets' => $datasets,
            ],
            'options' => $options,
        ];
    }

    public function chartConfig(): string
    {
        $config = $this->config();

        // An empty PHP array would encode as a JSON list; Chart.js needs an object.
        return json_encode(
            $config['options'] === [] ? ['options' => new \stdClass] + $config : $config,
            JSON_PRESERVE_ZERO_FRACTION
        ) ?: '{}';
    }

    public function render(): View
    {
        return view('adminlte::components.tool.chart');
    }

    /**
     * @param  array<string, mixed>  $legacy
     * @return array<int, mixed>
     */
    private function labels(array $legacy): array
    {
        foreach ([$this->categories, data_get($legacy, 'xaxis.categories'), $legacy['labels'] ?? null] as $labels) {
            if (is_array($labels) && $labels !== []) {
                return array_values($labels);
            }
        }

        return [];
    }

    /**
     * Turn `series` into Chart.js datasets. Accepts a list of series
     * (`['name' => …, 'data' => […]]`, plus any Chart.js dataset keys) or a
     * flat list of numbers (one value per slice for pie/donut charts).
     *
     * @param  array<string, mixed>  $legacy
     * @return array<int, array<string, mixed>>
     */
    private function datasets(string $type, string $requested, array $legacy): array
    {
        $colors = array_values((array) ($legacy['colors'] ?? []));

        if ($this->series === []) {
            return [];
        }

        $flat = ! in_array(false, array_map(fn ($v) => $v === null || is_int($v) || is_float($v), $this->series), true);
        if ($flat) {
            $dataset = ['data' => array_values($this->series)];
            if ($colors !== []) {
                $dataset[in_array($type, self::ARC_TYPES, true) ? 'backgroundColor' : 'borderColor']
                    = in_array($type, self::ARC_TYPES, true) ? $colors : $colors[0];
            }
            if ($requested === 'area') {
                $dataset['fill'] = 'origin';
            }

            return [$this->applyStroke($dataset, $type, $legacy)];
        }

        $datasets = [];
        foreach (array_values($this->series) as $i => $series) {
            if (! is_array($series)) {
                continue;
            }

            $label = $series['label'] ?? $series['name'] ?? null;
            $dataset = ($label !== null ? ['label' => $label] : [])
                + ['data' => array_values((array) ($series['data'] ?? []))]
                + array_diff_key($series, array_flip(self::LEGACY_SERIES_KEYS));

            // Mixed charts: a series may carry its own type.
            $seriesType = is_string($series['type'] ?? null) ? strtolower($series['type']) : $requested;
            $datasetType = self::TYPES[$seriesType] ?? $type;
            if ($datasetType !== $type) {
                $dataset['type'] = $datasetType;
            }
            if ($seriesType === 'area' && ! array_key_exists('fill', $dataset)) {
                $dataset['fill'] = 'origin';
            }

            $color = $series['color'] ?? $colors[$i] ?? null;
            if ($color !== null) {
                $key = $datasetType === 'bar' ? 'backgroundColor' : 'borderColor';
                $dataset[$key] ??= $color;
            }

            $datasets[] = $this->applyStroke($dataset, $datasetType, $legacy);
        }

        return $datasets;
    }

    /**
     * @param  array<string, mixed>  $dataset
     * @param  array<string, mixed>  $legacy
     * @return array<string, mixed>
     */
    private function applyStroke(array $dataset, string $type, array $legacy): array
    {
        if (! in_array($type, ['line', 'radar'], true)) {
            return $dataset;
        }

        $curve = data_get($legacy, 'stroke.curve');
        if ($curve === 'straight' && ! array_key_exists('tension', $dataset)) {
            $dataset['tension'] = 0;
        } elseif ($curve === 'stepline' && ! array_key_exists('stepped', $dataset)) {
            $dataset['stepped'] = true;
        }

        $width = data_get($legacy, 'stroke.width');
        if ((is_int($width) || is_float($width)) && ! array_key_exists('borderWidth', $dataset)) {
            $dataset['borderWidth'] = $width;
        }

        return $dataset;
    }
}
