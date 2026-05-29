<?php

namespace ColorlibHQ\AdminLte\View\Components\Widget;

use Illuminate\View\Component;
use Illuminate\View\View;

class DirectChat extends Component
{
    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    public function __construct(
        public array $items = [],
        public ?string $title = null,
        public ?string $class = null,
    ) {}

    public function render(): View
    {
        return view('adminlte::components.widget.direct-chat');
    }
}
