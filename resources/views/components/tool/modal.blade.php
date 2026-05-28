<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}-label" aria-hidden="true"
     @if ($staticBackdrop) data-bs-backdrop="static" data-bs-keyboard="false" @endif>
    <div class="{{ $dialogClass() }}">
        <div class="modal-content">
            <div class="modal-header {{ $theme ? 'text-bg-'.$theme : '' }}">
                <h5 class="modal-title" id="{{ $id }}-label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
