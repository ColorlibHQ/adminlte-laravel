<?php

namespace ColorlibHQ\AdminLte\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public string $id;

    public function __construct(
        public string $name,
        public ?string $label = null,
        public string $type = 'text',
        ?string $id = null,
        public ?string $igroupSize = null,   // sm | lg
        public ?string $fgroupClass = null,
        public bool $disableFeedback = false,
    ) {
        $this->id = $id ?? $name;
    }

    /**
     * Resolve the current value: old() input first, then any `value` attribute.
     */
    public function resolvedValue(mixed $fallback = null): mixed
    {
        return old($this->dotName(), $fallback);
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

    public function render(): View
    {
        return view('adminlte::components.form.input');
    }
}
