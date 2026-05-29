@extends('adminlte::page')

@section('title', 'General Elements')

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">General UI Elements</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item">UI Elements</li>
                <li class="breadcrumb-item active" aria-current="page">General</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        {{-- Buttons --}}
        <div class="col-md-6">
            <x-adminlte-card title="Buttons" icon="bi bi-hand-index">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach (['primary','secondary','success','danger','warning','info','light','dark'] as $t)
                        <button type="button" class="btn btn-{{ $t }}">{{ ucfirst($t) }}</button>
                    @endforeach
                </div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach (['primary','success','danger','warning','info'] as $t)
                        <button type="button" class="btn btn-outline-{{ $t }}">{{ ucfirst($t) }}</button>
                    @endforeach
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="btn btn-primary btn-lg">Large</button>
                    <button type="button" class="btn btn-primary">Default</button>
                    <button type="button" class="btn btn-primary btn-sm">Small</button>
                    <button type="button" class="btn btn-primary" disabled>Disabled</button>
                </div>
            </x-adminlte-card>

            {{-- Button group --}}
            <x-adminlte-card title="Button Group" icon="bi bi-segmented-nav">
                <div class="btn-group mb-2" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary">Left</button>
                    <button type="button" class="btn btn-primary">Middle</button>
                    <button type="button" class="btn btn-primary">Right</button>
                </div>
                <br>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary">1</button>
                    <button type="button" class="btn btn-outline-secondary">2</button>
                    <button type="button" class="btn btn-outline-secondary">3</button>
                </div>
            </x-adminlte-card>

            {{-- Alerts --}}
            <x-adminlte-card title="Alerts" icon="bi bi-exclamation-triangle">
                @foreach (['success' => 'check-circle', 'info' => 'info-circle', 'warning' => 'exclamation-triangle', 'danger' => 'x-circle'] as $t => $icon)
                    <div class="alert alert-{{ $t }} alert-dismissible fade show" role="alert">
                        <i class="bi bi-{{ $icon }} me-1"></i> A simple <strong>{{ $t }}</strong> alert — check it out!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            </x-adminlte-card>

            {{-- List group --}}
            <x-adminlte-card title="List Group" icon="bi bi-list-ul" bodyClass="p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Inbox <span class="badge text-bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        New messages <span class="badge text-bg-success rounded-pill">2</span>
                    </li>
                    <li class="list-group-item active">Active item</li>
                    <li class="list-group-item disabled">Disabled item</li>
                </ul>
            </x-adminlte-card>

            {{-- Pagination --}}
            <x-adminlte-card title="Pagination" icon="bi bi-three-dots">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </nav>
            </x-adminlte-card>
        </div>

        <div class="col-md-6">
            {{-- Typography --}}
            <x-adminlte-card title="Typography" icon="bi bi-fonts">
                <h1>Example heading <small class="text-muted fs-6">Sub-text</small></h1>
                <h2>Example heading</h2>
                <h3>Example heading</h3>
                <h4>Example heading</h4>
                <h5>Example heading</h5>
                <h6>Example heading</h6>
            </x-adminlte-card>

            {{-- Badges --}}
            <x-adminlte-card title="Badges" icon="bi bi-tag">
                <div class="d-flex flex-wrap gap-2">
                    @foreach (['primary','secondary','success','danger','warning','info','light','dark'] as $t)
                        <span class="badge text-bg-{{ $t }}">{{ ucfirst($t) }}</span>
                    @endforeach
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach (['primary','success','danger'] as $t)
                        <span class="badge rounded-pill text-bg-{{ $t }}">{{ ucfirst($t) }}</span>
                    @endforeach
                </div>
            </x-adminlte-card>

            {{-- Progress --}}
            <x-adminlte-card title="Progress" icon="bi bi-reception-4">
                @foreach (['primary' => 25, 'success' => 50, 'info' => 75, 'warning' => 100] as $t => $v)
                    <div class="progress mb-2" role="progressbar" aria-valuenow="{{ $v }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar text-bg-{{ $t }}" style="width: {{ $v }}%">{{ $v }}%</div>
                    </div>
                @endforeach
                <div class="progress" role="progressbar">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 60%"></div>
                </div>
            </x-adminlte-card>

            {{-- Spinners --}}
            <x-adminlte-card title="Spinners" icon="bi bi-arrow-clockwise">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    @foreach (['primary','secondary','success','danger','warning','info'] as $t)
                        <div class="spinner-border text-{{ $t }}" role="status"><span class="visually-hidden">Loading…</span></div>
                    @endforeach
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3 mt-3">
                    @foreach (['primary','success','danger'] as $t)
                        <div class="spinner-grow text-{{ $t }}" role="status"><span class="visually-hidden">Loading…</span></div>
                    @endforeach
                </div>
            </x-adminlte-card>

            {{-- Dropdowns --}}
            <x-adminlte-card title="Dropdowns" icon="bi bi-caret-down">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                </div>
            </x-adminlte-card>

            {{-- Placeholders --}}
            <x-adminlte-card title="Placeholders" icon="bi bi-card-text">
                <p class="placeholder-glow">
                    <span class="placeholder col-12"></span>
                    <span class="placeholder col-8"></span>
                    <span class="placeholder col-10"></span>
                    <span class="placeholder col-6"></span>
                </p>
            </x-adminlte-card>

            {{-- Tooltips & Toasts --}}
            <x-adminlte-card title="Tooltips &amp; Toasts" icon="bi bi-chat-square">
                <button type="button" class="btn btn-secondary me-2" data-bs-toggle="tooltip" data-bs-title="Hello! I'm a tooltip">
                    Hover me
                </button>
                <button type="button" class="btn btn-primary" id="generalToastBtn">Show toast</button>

                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="generalToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <i class="bi bi-bell-fill text-primary me-2"></i>
                            <strong class="me-auto">AdminLTE</strong>
                            <small>just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">Hello, this is a toast notification!</div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tooltips
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
            // Toast demo
            const btn = document.getElementById('generalToastBtn');
            const toastEl = document.getElementById('generalToast');
            if (btn && toastEl) {
                btn.addEventListener('click', () => bootstrap.Toast.getOrCreateInstance(toastEl).show());
            }
        });
    </script>
@endpush
