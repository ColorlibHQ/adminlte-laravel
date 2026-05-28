<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class AccordionItem extends Component
{
    public string $id;

    public function __construct(
        public string $title,
        public string $parent,
        ?string $id = null,
        public bool $expanded = false,
        public ?string $class = null,
    ) {
        $this->id = $id ?? 'item-' . uniqid();
    }

    public function render(): View
    {
        return view('adminlte::components.widget.accordion-item');
    }
}
