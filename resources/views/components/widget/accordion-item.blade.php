<div class="accordion-item @if ($class) {{ $class }} @endif">
    <h2 class="accordion-header" id="heading-{{ $id }}">
        <button class="accordion-button @if (!$expanded) collapsed @endif"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#{{ $id }}"
                @if (!$expanded) aria-expanded="false" @else aria-expanded="true" @endif
                aria-controls="{{ $id }}">
            {{ $title }}
        </button>
    </h2>
    <div id="{{ $id }}"
         class="accordion-collapse collapse @if ($expanded) show @endif"
         aria-labelledby="heading-{{ $id }}"
         data-bs-parent="#{{ $parent }}">
        <div class="accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>
