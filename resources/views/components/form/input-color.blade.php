<div class="mb-3 {{ $fgroupClass }}">
    @isset($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endisset
    <input type="color"
           name="{{ $name }}"
           id="{{ $id }}"
           value="{{ $resolvedValue() }}"
           {{ $attributes->merge(['class' => 'form-control form-control-color'.($hasError() ? ' is-invalid' : '')]) }}>
    @if ($hasError())
        <div class="invalid-feedback d-block">{{ $errorMessage() }}</div>
    @endif
</div>
