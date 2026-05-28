<div id="{{ $id }}" class="datatable-container {{ $class }}"></div>

@push('scripts')
    <script>
        var table = new Tabulator('#{{ $id }}', {!! $tabulatorConfig() !!});
    </script>
@endpush
