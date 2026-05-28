<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Progress extends Component
{
    public function __construct(
        public int|string $value = 0,
        public string $theme = 'primary',
        public bool $striped = false,
        public bool $animated = false,
        public ?string $height = null,
        public bool $showLabel = false,
    ) {}

    public function barClass(): string
    {
        return collect([
            'progress-bar',
            'text-bg-'.$this->theme,
            $this->striped || $this->animated ? 'progress-bar-striped' : null,
            $this->animated ? 'progress-bar-animated' : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('adminlte::components.widget.progress');
    }
}
