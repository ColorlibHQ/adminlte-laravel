<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use Illuminate\View\Component;
use Illuminate\View\View;

class Modal extends Component
{
    public function __construct(
        public string $id,
        public ?string $title = null,
        public ?string $size = null,        // sm | lg | xl
        public ?string $theme = null,        // header background: text-bg-{theme}
        public bool $staticBackdrop = false,
        public bool $scrollable = false,
        public bool $centered = false,
    ) {}

    public function dialogClass(): string
    {
        return collect([
            'modal-dialog',
            $this->size ? 'modal-'.$this->size : null,
            $this->scrollable ? 'modal-dialog-scrollable' : null,
            $this->centered ? 'modal-dialog-centered' : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('adminlte::components.tool.modal');
    }
}
