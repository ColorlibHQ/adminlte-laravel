<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class Calendar extends Component
{
    public string $id;

    /**
     * @param  array<int, mixed>|string  $events
     * @param  array<string, mixed>  $options
     */
    public function __construct(
        public array|string $events = [],
        public array $options = [],
        ?string $id = null,
        public string $height = '500px',
    ) {
        $this->id = $id ?? 'calendar-'.uniqid();
        app(PluginManager::class)->enable('fullcalendar');
    }

    public function calendarConfig(): string
    {
        $config = array_merge([
            'initialView' => 'dayGridMonth',
            'height' => $this->height,
            'events' => is_array($this->events) ? $this->events : $this->events,
        ], $this->options);

        return json_encode($config) ?: '{}';
    }

    public function render(): View
    {
        return view('adminlte::components.tool.calendar');
    }
}
