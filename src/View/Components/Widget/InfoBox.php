<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class InfoBox extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $text = null,
        public ?string $icon = null,
        public ?string $theme = null,        // applied to the icon area: text-bg-{theme}
        public ?string $iconTheme = null,
        public ?string $progress = null,     // 0-100 -> progress bar
        public ?string $progressText = null,
    ) {}

    public function iconClass(): string
    {
        $theme = $this->iconTheme ?? $this->theme;

        return collect([
            'info-box-icon',
            $theme ? 'text-bg-'.$theme : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('adminlte::components.widget.info-box');
    }
}
