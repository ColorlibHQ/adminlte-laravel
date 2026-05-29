<?php

namespace ColorlibHQ\AdminLte\View\Components\Tool;

use ColorlibHQ\AdminLte\Plugins\PluginManager;
use Illuminate\View\Component;
use Illuminate\View\View;

class Editor extends Component
{
    public string $id;

    /**
     * @param  array<string, mixed>  $quillOptions
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public ?string $value = null,
        ?string $id = null,
        public array $quillOptions = [],
        public ?string $fgroupClass = null,
        public bool $disableFeedback = false,
        public ?string $placeholder = null,
    ) {
        $this->id = $id ?? $name;
        app(PluginManager::class)->enable('quill');
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

    public function quillConfig(): string
    {
        $config = array_merge([
            'theme' => 'snow',
            'placeholder' => $this->placeholder ?? __('adminlte.enter_text'),
        ], $this->quillOptions);

        return json_encode($config) ?: '{}';
    }

    public function render(): View
    {
        return view('adminlte::components.tool.editor');
    }
}
