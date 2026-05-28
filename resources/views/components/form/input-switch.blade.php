<div class="mb-3 {{ $fgroupClass }}">
    <div class="form-check form-switch">
        <input type="checkbox"
               name="{{ $name }}"
               id="{{ $id }}"
               value="{{ $value }}"
               @checked($isChecked())
               {{ $attributes->merge(['class' => 'form-check-input'.($hasError() ? ' is-invalid' : '')]) }}>
        @isset($label)
            <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
        @endisset
        @if ($hasError())
            <div class="invalid-feedback d-block">{{ $errorMessage() }}</div>
        @endif
    </div>
</div>
