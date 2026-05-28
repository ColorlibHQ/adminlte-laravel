<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavNotifications extends Component
{
    public function __construct(
        public array $notifications = [],
        public ?string $badgeColor = 'danger',
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.nav-notifications');
    }
}
