<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavMessages extends Component
{
    /**
     * @param  array<int, array<string, mixed>>  $messages
     */
    public function __construct(
        public array $messages = [],
        public ?string $badgeColor = 'info',
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.nav-messages');
    }
}
