<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    public function __construct(
        public string $theme = 'info',
        public ?string $title = null,
        public ?string $icon = null,
        public bool $dismissable = false,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.alert');
    }
}
