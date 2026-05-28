<li class="nav-item" role="presentation">
    <button class="nav-link @if ($active) active @endif"
            id="{{ $id }}-tab"
            data-bs-toggle="tab"
            data-bs-target="#{{ $id }}"
            type="button"
            role="tab"
            aria-controls="{{ $id }}"
            @if ($active) aria-selected="true" @else aria-selected="false" @endif>
        @if ($icon)
            <i class="{{ $icon }} me-2"></i>
        @endif
        {{ $title }}
    </button>
</li>
<div class="tab-pane @if ($active) active @endif" id="{{ $id }}" role="tabpanel" aria-labelledby="{{ $id }}-tab">
    {{ $slot }}
</div>
