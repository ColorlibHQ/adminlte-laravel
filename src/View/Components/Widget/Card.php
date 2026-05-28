<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Card extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $theme = null,        // primary, success, ...
        public bool $outline = false,
        public bool $collapsible = false,
        public bool $collapsed = false,
        public bool $removable = false,
        public bool $maximizable = false,
        public ?string $bodyClass = null,
        public ?string $headerClass = null,
        public ?string $footerClass = null,
    ) {}

    /**
     * Build the wrapper class string for the .card element.
     */
    public function cardClass(): string
    {
        return collect([
            'card',
            $this->theme ? 'card-'.$this->theme : null,
            $this->outline ? 'card-outline' : null,
            $this->collapsed ? 'collapsed-card' : null,
        ])->filter()->implode(' ');
    }

    public function hasTools(): bool
    {
        return $this->collapsible || $this->removable || $this->maximizable;
    }

    public function render(): View
    {
        return view('adminlte::components.widget.card');
    }
}
