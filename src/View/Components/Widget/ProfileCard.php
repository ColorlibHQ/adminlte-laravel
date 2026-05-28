<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProfileCard extends Component
{
    public function __construct(
        public string $name,
        public ?string $title = null,
        public ?string $image = null,
        public ?string $imageAlt = null,
        public array $socials = [],
        public ?string $description = null,
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.profile-card');
    }
}
