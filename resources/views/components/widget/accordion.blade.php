<div class="accordion @if ($flush) accordion-flush @endif @if ($class) {{ $class }} @endif"
     id="{{ $id }}"
     @if ($alwaysOpen) data-bs-always-open @endif>
    {{ $slot }}
</div>
