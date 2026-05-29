<?php

namespace ColorlibHQ\AdminLte\View\Components\Form;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class InputTomSelect extends Component
{
    public string $id;

    public function __construct(
        public string $name,
        public ?string $label = null,
        /** @var array<int|string, mixed> */
        public array $options = [],
        public mixed $value = null,
        ?string $id = null,
        public bool $multiple = false,
        public bool $searchable = true,
        public ?string $placeholder = null,
        public ?string $igroupSize = null,
        public ?string $fgroupClass = null,
        public bool $disableFeedback = false,
        /** @var array<string, mixed> */
        public array $tomSelectOptions = [],
    ) {
        $this->id = $id ?? $name;
        app(PluginManager::class)->enable('tom_select');
    }

    public function resolvedValue(): mixed
    {
        $old = old($this->dotName());
        if ($old !== null) {
            return $old;
        }

        return $this->value;
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

    public function tomSelectConfig(): string
    {
        $config = array_merge([
            'create' => false,
            'placeholder' => $this->placeholder ?? __('adminlte.select_option'),
        ], $this->tomSelectOptions);

        return json_encode($config) ?: '{}';
    }

    public function render(): View
    {
        return view('adminlte::components.form.input-tom-select');
    }
}
