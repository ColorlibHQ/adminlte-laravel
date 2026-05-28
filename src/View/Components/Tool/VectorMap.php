<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class VectorMap extends Component
{
    public string $id;

    public function __construct(
        public string $map = 'world_merc',
        public array $markers = [],
        public array $regions = [],
        public array $options = [],
        ?string $id = null,
        public string $height = '400px',
    ) {
        $this->id = $id ?? 'vectormap-' . uniqid();
        app(PluginManager::class)->enable('jsvectormap');
    }

    public function mapConfig(): string
    {
        $config = array_merge([
            'map' => $this->map,
            'markers' => $this->markers,
            'regions' => $this->regions,
        ], $this->options);

        return json_encode($config);
    }

    public function render(): View
    {
        return view('adminlte::components.tool.vector-map');
    }
}
