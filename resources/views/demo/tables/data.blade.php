@extends('adminlte::page')

@section('title', 'Data Tables')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Tables</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{--
        NOTE: The original AdminLTE 4 page renders this users table with the
        Tabulator plugin (client-side filtering, sorting, pagination, CSV/JSON
        export and print). To keep this demo working WITHOUT requiring an extra
        plugin to be loaded, it is recreated below as a styled Bootstrap table
        with a search input and static pagination markup.

        To make it a fully interactive, sortable/searchable data grid you can
        wire it to this package's Tabulator-based datatable component:

            <x-adminlte-datatable
                :headers="['#', 'Name', 'Email', 'Role', 'Status', 'Joined']"
                :data="$users"
            />

        That component registers the 'tabulator' plugin via PluginManager, so
        its assets are injected through @pluginStyles / @pluginScripts.
    --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 16rem">
                    <span class="input-group-text">
                        <i class="bi bi-search" aria-hidden="true"></i>
                    </span>
                    <input
                        id="table-filter"
                        type="search"
                        class="form-control"
                        placeholder="Filter rows…"
                        aria-label="Filter rows"
                    >
                </div>
            </div>
        </div>
        {{-- /.card-header --}}
        <div class="card-body">
            <div class="d-flex gap-2 mb-3">
                <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                    Export CSV
                </button>
                <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                    Export JSON
                </button>
                <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer me-1" aria-hidden="true"></i>
                    Print
                </button>
            </div>

            <div class="table-responsive">
                <table id="users-table" class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 120px">Role</th>
                            <th style="width: 130px" class="text-center">Status</th>
                            <th style="width: 130px">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $users = [
                                ['id' => 1, 'name' => 'Olivia Bennett', 'email' => 'olivia@example.com', 'role' => 'Admin', 'status' => 'Active', 'joined' => '2024-03-12'],
                                ['id' => 2, 'name' => 'Liam Carter', 'email' => 'liam@example.com', 'role' => 'Editor', 'status' => 'Active', 'joined' => '2024-04-08'],
                                ['id' => 3, 'name' => 'Emma Dawson', 'email' => 'emma@example.com', 'role' => 'Viewer', 'status' => 'Invited', 'joined' => '2024-06-21'],
                                ['id' => 4, 'name' => 'Noah Evans', 'email' => 'noah@example.com', 'role' => 'Editor', 'status' => 'Suspended', 'joined' => '2024-07-15'],
                                ['id' => 5, 'name' => 'Ava Foster', 'email' => 'ava@example.com', 'role' => 'Admin', 'status' => 'Active', 'joined' => '2024-08-30'],
                                ['id' => 6, 'name' => 'Ethan Grant', 'email' => 'ethan@example.com', 'role' => 'Viewer', 'status' => 'Active', 'joined' => '2024-09-14'],
                                ['id' => 7, 'name' => 'Sophia Hayes', 'email' => 'sophia@example.com', 'role' => 'Editor', 'status' => 'Active', 'joined' => '2024-10-02'],
                                ['id' => 8, 'name' => 'Mason Ingram', 'email' => 'mason@example.com', 'role' => 'Viewer', 'status' => 'Invited', 'joined' => '2024-11-19'],
                                ['id' => 9, 'name' => 'Isabella Jones', 'email' => 'isabella@example.com', 'role' => 'Admin', 'status' => 'Active', 'joined' => '2025-01-05'],
                                ['id' => 10, 'name' => 'Lucas Klein', 'email' => 'lucas@example.com', 'role' => 'Viewer', 'status' => 'Suspended', 'joined' => '2025-02-18'],
                                ['id' => 11, 'name' => 'Mia Lopez', 'email' => 'mia@example.com', 'role' => 'Editor', 'status' => 'Active', 'joined' => '2025-03-22'],
                                ['id' => 12, 'name' => 'Logan Moore', 'email' => 'logan@example.com', 'role' => 'Viewer', 'status' => 'Active', 'joined' => '2025-04-09'],
                                ['id' => 13, 'name' => 'Charlotte Nelson', 'email' => 'charlotte@example.com', 'role' => 'Admin', 'status' => 'Active', 'joined' => '2025-04-27'],
                                ['id' => 14, 'name' => 'Henry Owens', 'email' => 'henry@example.com', 'role' => 'Editor', 'status' => 'Invited', 'joined' => '2025-05-11'],
                                ['id' => 15, 'name' => 'Amelia Price', 'email' => 'amelia@example.com', 'role' => 'Viewer', 'status' => 'Active', 'joined' => '2025-05-17'],
                            ];

                            $statusThemes = [
                                'Active' => 'success',
                                'Invited' => 'info',
                                'Suspended' => 'secondary',
                            ];
                        @endphp

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user['id'] }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['role'] }}</td>
                                <td class="text-center">
                                    <span class="badge text-bg-{{ $statusThemes[$user['status']] ?? 'secondary' }}">
                                        {{ $user['status'] }}
                                    </span>
                                </td>
                                <td>{{ $user['joined'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Static pagination markup --}}
            <nav class="d-flex justify-content-end" aria-label="Table pagination">
                <ul class="pagination pagination-sm m-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&laquo;</a>
                    </li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
        {{-- /.card-body --}}
        <div class="card-footer text-secondary small">
            Static demo table &mdash; replace with
            <code>&lt;x-adminlte-datatable&gt;</code> (Tabulator) for live filtering,
            sorting, export and print.
        </div>
    </div>
    {{-- /.card --}}
@stop

@push('js')
    {{-- Lightweight vanilla JS to keep the search box and export/print buttons
         functional against the static table above (no plugin required). --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filter = document.getElementById('table-filter');
            const table = document.getElementById('users-table');
            if (!table) return;

            const rows = Array.from(table.querySelectorAll('tbody tr'));

            // Client-side row filtering
            if (filter) {
                filter.addEventListener('input', function (e) {
                    const term = e.target.value.trim().toLowerCase();
                    rows.forEach(function (row) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = !term || text.includes(term) ? '' : 'none';
                    });
                });
            }

            // Collect currently visible data
            const headers = Array.from(table.querySelectorAll('thead th'))
                .map(function (th) { return th.textContent.trim(); });

            const visibleRows = function () {
                return rows.filter(function (row) { return row.style.display !== 'none'; });
            };

            const rowData = function (row) {
                return Array.from(row.querySelectorAll('td'))
                    .map(function (td) { return td.textContent.trim().replace(/\s+/g, ' '); });
            };

            const download = function (filename, content, type) {
                const blob = new Blob([content], { type: type });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            };

            const csvBtn = document.getElementById('export-csv');
            if (csvBtn) {
                csvBtn.addEventListener('click', function () {
                    const escape = function (v) { return '"' + String(v).replace(/"/g, '""') + '"'; };
                    const lines = [headers.map(escape).join(',')];
                    visibleRows().forEach(function (row) {
                        lines.push(rowData(row).map(escape).join(','));
                    });
                    download('users.csv', lines.join('\n'), 'text/csv');
                });
            }

            const jsonBtn = document.getElementById('export-json');
            if (jsonBtn) {
                jsonBtn.addEventListener('click', function () {
                    const data = visibleRows().map(function (row) {
                        const cells = rowData(row);
                        const obj = {};
                        headers.forEach(function (h, i) { obj[h] = cells[i]; });
                        return obj;
                    });
                    download('users.json', JSON.stringify(data, null, 2), 'application/json');
                });
            }

            const printBtn = document.getElementById('print-table');
            if (printBtn) {
                printBtn.addEventListener('click', function () { window.print(); });
            }
        });
    </script>
@endpush
