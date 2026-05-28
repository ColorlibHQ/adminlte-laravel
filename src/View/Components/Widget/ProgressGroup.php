<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProgressGroup extends Component
{
    public function __construct(
        public string $label,
        public int $value,
        public string $color = 'primary',
        public ?int $max = 100,
        public bool $showPercentage = true,
    ) {}

    public function percentage(): int
    {
        return round(($this->value / ($this->max ?? 100)) * 100);
    }

    public function render(): View
    {
        return view('adminlte::components.widget.progress-group');
    }
}
