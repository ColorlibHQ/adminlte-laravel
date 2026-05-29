@extends('adminlte::page')

@section('title', 'Cards')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Cards</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Widgets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cards</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <h4 class="mb-2">Cards</h4>

    <h5 class="mb-2">Abilities</h5>
    {{-- begin::Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Expandable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Collapsable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Removable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Maximizable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-maximize">
                            <i data-lte-icon="maximize" class="bi bi-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}

    <h5 class="mb-2">Card Outlined</h5>
    {{-- begin::Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Expandable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Collapsable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Removable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Maximizable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-maximize">
                            <i data-lte-icon="maximize" class="bi bi-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}

    <h5 class="mb-2">Card with <code>.text-bg-*</code></h5>
    {{-- begin::Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Expandable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-header">
                    <h3 class="card-title">Collapsable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-header">
                    <h3 class="card-title">Removable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <div class="card text-bg-danger">
                <div class="card-header">
                    <h3 class="card-title">Maximizable</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-maximize">
                            <i data-lte-icon="maximize" class="bi bi-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"></i>
                        </button>
                    </div>
                    {{-- /.card-tools --}}
                </div>
                {{-- /.card-header --}}
                <div class="card-body">The body of the card</div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}
@stop
