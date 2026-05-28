<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Breadcrumb extends Component
{
    public function __construct(
        public array $items = [],
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.breadcrumb');
    }
}
