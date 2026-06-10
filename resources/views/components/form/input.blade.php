<div class="mb-3 {{ $fgroupClass }}">
    @isset($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endisset

    @isset($prepend)
        <div class="input-group {{ $igroupSize ? 'input-group-'.$igroupSize : '' }}">
            <span class="input-group-text">{{ $prepend }}</span>
    @endisset

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $resolvedValue($attributes->get('value')) }}"
        @if ($hasError()) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
        {{ $attributes->except('value')->merge(['class' => 'form-control'.($hasError() ? ' is-invalid' : '')]) }}>

    @isset($append)
            <span class="input-group-text">{{ $append }}</span>
        </div>
    @endisset

    @if ($hasError())
        <div class="invalid-feedback d-block" id="{{ $id }}-error">{{ $errorMessage() }}</div>
    @endif

    {{ $slot ?? '' }}
</div>
