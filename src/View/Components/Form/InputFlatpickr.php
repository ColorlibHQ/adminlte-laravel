<?php

namespace ColorlibHQ\AdminLte\View\Components\Form;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class InputFlatpickr extends Component
{
    public string $id;

    public function __construct(
        public string $name,
        public ?string $label = null,
        public string $type = 'text', // 'date', 'time', 'datetime'
        public ?string $value = null,
        ?string $id = null,
        public ?string $igroupSize = null,   // sm | lg
        public ?string $fgroupClass = null,
        public bool $disableFeedback = false,
        public ?string $placeholder = null,
        public array $options = [],
    ) {
        $this->id = $id ?? $name;
        app(PluginManager::class)->enable('flatpickr');
    }

    public function resolvedValue(): mixed
    {
        return old($this->dotName(), $this->value);
    }

    public function dotName(): string
    {
        return str_replace(['[', ']'], ['.', ''], $this->name);
    }

    public function hasError(): bool
    {
        return ! $this->disableFeedback
            && session('errors')
            && session('errors')->has($this->dotName());
    }

    public function errorMessage(): ?string
    {
        return $this->hasError()
            ? session('errors')->first($this->dotName())
            : null;
    }

    public function flatpickrConfig(): string
    {
        $config = [];

        if ($this->type === 'date') {
            $config['mode'] = 'single';
        } elseif ($this->type === 'time') {
            $config['enableTime'] = true;
            $config['noCalendar'] = true;
            $config['mode'] = 'single';
        } elseif ($this->type === 'datetime') {
            $config['enableTime'] = true;
            $config['mode'] = 'single';
        }

        return json_encode(array_merge($config, $this->options));
    }

    public function render(): View
    {
        return view('adminlte::components.form.input-flatpickr');
    }
}
