@php
    $hasError = $hasError();
    $error = $errorMessage();
    $selectedValues = [];
    if ($resolvedValue()) {
        $selectedValues = is_array($resolvedValue()) ? $resolvedValue() : [$resolvedValue()];
    }
@endphp

<div class="form-group {{ $fgroupClass }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <select id="{{ $id }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            class="form-select @error($dotName()) is-invalid @enderror"
            data-tom-select
            data-tom-select-config="{{ $tomSelectConfig() }}"
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
            {{ $multiple ? 'multiple' : '' }}
            {{ $attributes->whereDoesntStartWith('class') }}>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}"
                    {{ in_array($optionValue, $selectedValues) ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if ($hasError)
        <div class="invalid-feedback d-block" id="{{ $id }}-error">{{ $error }}</div>
    @endif
</div>
