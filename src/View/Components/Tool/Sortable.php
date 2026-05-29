<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class Sortable extends Component
{
    /**
     * @param  array<string, mixed>  $options
     */
    public function __construct(
        public string $group = 'shared',
        public array $options = [],
        public ?string $class = null,
    ) {
        app(PluginManager::class)->enable('sortablejs');
    }

    public function render(): View
    {
        return view('adminlte::components.tool.sortable');
    }
}
