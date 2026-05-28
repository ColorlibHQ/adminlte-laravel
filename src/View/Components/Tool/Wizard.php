<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use Illuminate\View\Component;
use Illuminate\View\View;

class Wizard extends Component
{
    public string $id;

    public function __construct(
        public int $steps = 3,
        ?string $id = null,
        public ?string $class = null,
    ) {
        $this->id = $id ?? 'wizard-'.uniqid();
    }

    public function render(): View
    {
        return view('adminlte::components.tool.wizard');
    }
}
