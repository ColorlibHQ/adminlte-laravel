<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Toast extends Component
{
    public string $id;

    public function __construct(
        public ?string $title = null,
        public string $position = 'top-end',
        public bool $autohide = true,
        public int $delay = 5000,
        public string $theme = 'primary',
        public ?string $icon = null,
        ?string $id = null,
        public ?string $class = null,
    ) {
        $this->id = $id ?? 'toast-'.uniqid();
    }

    public function render(): View
    {
        return view('adminlte::components.widget.toast');
    }
}
