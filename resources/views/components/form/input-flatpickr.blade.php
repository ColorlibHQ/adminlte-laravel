@php
    $hasError = $hasError();
    $error = $errorMessage();
@endphp

<div class="form-group {{ $fgroupClass }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="input-group {{ $igroupSize ? 'input-group-' . $igroupSize : '' }}">
        <input type="text"
               id="{{ $id }}"
               name="{{ $name }}"
               value="{{ $resolvedValue() }}"
               class="form-control @error($dotName()) is-invalid @enderror"
               placeholder="{{ $placeholder ?? __('adminlte.select_date') }}"
               data-flatpickr
               data-flatpickr-config="{{ $flatpickrConfig() }}"
               {{ $attributes->whereDoesntStartWith('class') }}>
        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
    </div>

    @if ($hasError)
        <div class="invalid-feedback d-block">{{ $error }}</div>
    @endif
</div>
