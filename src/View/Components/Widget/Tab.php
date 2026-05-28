<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tab extends Component
{
    public string $id;

    public function __construct(
        public string $title,
        ?string $id = null,
        public bool $active = false,
        public ?string $icon = null,
        public ?string $class = null,
    ) {
        $this->id = $id ?? 'tab-' . uniqid();
    }

    public function render(): View
    {
        return view('adminlte::components.widget.tab');
    }
}
