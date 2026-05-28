<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class Datatable extends Component
{
    public string $id;

    public function __construct(
        ?string $id = null,
        public array $columns = [],
        public array $data = [],
        public ?string $apiUrl = null,
        public array $tabulatorOptions = [],
        public ?string $class = null,
    ) {
        $this->id = $id ?? 'datatable-'.uniqid();
        app(PluginManager::class)->enable('tabulator');
    }

    public function tabulatorConfig(): string
    {
        $config = [
            'columns' => $this->columns,
        ];

        if ($this->apiUrl) {
            $config['ajaxURL'] = $this->apiUrl;
        } else {
            $config['data'] = $this->data;
        }

        return json_encode(array_merge($config, $this->tabulatorOptions));
    }

    public function render(): View
    {
        return view('adminlte::components.tool.datatable');
    }
}
