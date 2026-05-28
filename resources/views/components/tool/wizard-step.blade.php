<div class="step-pane @if ($step === 1) active @endif" data-step="{{ $step }}" @if ($class) class="{{ $class }}" @endif>
    <h4>{{ $title }}</h4>
    {{ $slot }}
    <div class="mt-4">
        @if ($step > 1)
            <button type="button" class="btn btn-secondary" onclick="showStep({{ $step - 1 }})">
                {{ __('adminlte.previous') ?? 'Previous' }}
            </button>
        @endif
        @if ($step > 0)
            <button type="button" class="btn btn-primary" onclick="showStep({{ $step + 1 }})">
                {{ __('adminlte.next') ?? 'Next' }}
            </button>
        @endif
    </div>
</div>
