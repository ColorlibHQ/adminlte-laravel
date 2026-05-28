<?php

namespace ColorlibHQ\AdminLte\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    public string $id;

    public function __construct(
        public string $name,
        public ?string $label = null,
        ?string $id = null,
        public ?string $fgroupClass = null,
        public bool $disableFeedback = false,
    ) {
        $this->id = $id ?? $name;
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
        return $this->hasError() ? session('errors')->first($this->dotName()) : null;
    }

    public function render(): View
    {
        return view('adminlte::components.form.select');
    }
}
