<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Accordion extends Component
{
    public string $id;

    public function __construct(
        ?string $id = null,
        public bool $flush = false,
        public bool $alwaysOpen = false,
        public ?string $class = null,
    ) {
        $this->id = $id ?? 'accordion-' . uniqid();
    }

    public function render(): View
    {
        return view('adminlte::components.widget.accordion');
    }
}
