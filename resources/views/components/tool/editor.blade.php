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
         data-quill-options="{{ $quillConfig() }}"
         data-quill-target="#{{ $id }}-value"></div>

    @if ($hasError)
        <div class="invalid-feedback d-block">{{ $error }}</div>
    @endif
</div>

@push('scripts')
    <script>
        if (document.querySelector('[data-quill]')) {
            document.querySelectorAll('[data-quill]').forEach(el => {
                const targetInput = document.querySelector(el.getAttribute('data-quill-target'));
                const options = JSON.parse(el.getAttribute('data-quill-options') || '{}');

                const quill = new Quill(el, options);

                if (targetInput?.value) {
                    quill.root.innerHTML = targetInput.value;
                }

                quill.on('text-change', () => {
                    targetInput.value = quill.root.innerHTML;
                });
            });
        }
    </script>
@endpush
