<div class="sortable-list @if ($class) {{ $class }} @endif"
     data-sortable
     data-sortable-group="{{ $group }}"
     data-sortable-options="{{ json_encode($options) }}">
    {{ $slot }}
</div>
