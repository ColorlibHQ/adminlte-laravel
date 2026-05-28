<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class DescriptionBlock extends Component
{
    public function __construct(
        public string $title,
        public ?string $text = null,
        public array $items = [],
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.description-block');
    }
}
