<div id="{{ $id }}"
     class="toast align-items-center text-white bg-{{ $theme }} border-0 @if ($class) {{ $class }} @endif"
     role="alert"
     aria-live="assertive"
     aria-atomic="true"
     @if ($autohide) data-bs-autohide="true" data-bs-delay="{{ $delay }}" @endif>
    <div class="d-flex">
        @if ($icon)
            <div class="toast-body">
                <i class="{{ $icon }} me-2"></i>
                @if ($title)
                    <strong>{{ $title }}</strong>
                @endif
                {{ $slot }}
            </div>
        @else
            <div class="toast-body">
                @if ($title)
                    <strong>{{ $title }}</strong><br>
                @endif
                {{ $slot }}
            </div>
        @endif
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
