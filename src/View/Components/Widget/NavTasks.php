<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavTasks extends Component
{
    /**
     * @param  array<int, array<string, mixed>>  $tasks
     */
    public function __construct(
        public array $tasks = [],
        public ?string $badgeColor = 'warning',
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.nav-tasks');
    }
}
