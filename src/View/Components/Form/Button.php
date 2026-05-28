<?php

namespace ColorlibHQ\AdminLte\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public function __construct(
        public string $type = 'button',     // button | submit | reset
        public string $theme = 'primary',
        public bool $outline = false,
        public ?string $size = null,        // sm | lg
        public ?string $icon = null,
        public ?string $label = null,
    ) {}

    public function buttonClass(): string
    {
        return collect([
            'btn',
            'btn-'.($this->outline ? 'outline-' : '').$this->theme,
            $this->size ? 'btn-'.$this->size : null,
        ])->filter()->implode(' ');
    }

    public function render(): View
    {
        return view('adminlte::components.form.button');
    }
}
