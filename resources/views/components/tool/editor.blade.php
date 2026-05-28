@php
    $hasError = $hasError();
    $error = $errorMessage();
@endphp

<div class="form-group {{ $fgroupClass }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <input type="hidden" name="{{ $name }}" id="{{ $id }}-value" value="{{ $resolvedValue() }}">

    <div id="{{ $id }}"
         class="quill-editor @error($dotName()) is-invalid @enderror"
         data-quill
         data-quill-config="{{ $quillConfig() }}"
         data-quill-target="#{{ $id }}-value"></div>

    @if ($hasError)
        <div class="invalid-feedback d-block">{{ $error }}</div>
    @endif
</div>
