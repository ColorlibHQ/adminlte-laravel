<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class SmallBox extends Component
{
    public function __construct(
        public ?string $title = null,      // the big number/value
        public ?string $text = null,       // the label under it
        public ?string $icon = null,       // bi icon class
        public string $theme = 'primary',  // text-bg-{theme}
        public ?string $url = null,        // "more info" link
        public ?string $urlText = 'More info',
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.small-box');
    }
}
