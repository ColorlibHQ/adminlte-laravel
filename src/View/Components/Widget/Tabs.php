<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tabs extends Component
{
    public function __construct(
        public string $variant = 'tabs',
        public bool $justified = false,
        public bool $fill = false,
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.tabs');
    }
}
