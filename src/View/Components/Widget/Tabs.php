<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tabs extends Component
{
    /**
     * Blade stack name that child <x-adminlte-tab> panes push onto, so they
     * render inside .tab-content instead of the nav <ul>. One tab group per
     * page is assumed; multiple groups on one page would share panes.
     */
    public const PANE_STACK = 'adminlte-tab-panes';

    public function __construct(
        public string $variant = 'tabs',
        public bool $justified = false,
        public bool $fill = false,
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.tabs');
    }
}
