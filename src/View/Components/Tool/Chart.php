<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class Chart extends Component
{
    public string $id;

    public function __construct(
        public string $type = 'area',
        public array $series = [],
        public array $categories = [],
        public array $options = [],
        ?string $id = null,
        public string $height = '300px',
    ) {
        $this->id = $id ?? 'chart-' . uniqid();
        app(PluginManager::class)->enable('apexcharts');
    }

    public function chartConfig(): string
    {
        $config = array_merge([
            'chart' => [
                'type' => $this->type,
                'height' => intval(str_replace('px', '', $this->height)),
            ],
            'series' => $this->series,
            'xaxis' => [
                'categories' => $this->categories,
            ],
        ], $this->options);

        return json_encode($config);
    }

    public function render(): View
    {
        return view('adminlte::components.tool.chart');
    }
}
