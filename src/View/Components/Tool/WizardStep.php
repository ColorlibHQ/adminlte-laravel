<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use Illuminate\View\Component;
use Illuminate\View\View;

class WizardStep extends Component
{
    public function __construct(
        public int $step,
        public string $title,
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.tool.wizard-step');
    }
}
