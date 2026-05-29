@extends('adminlte::page')

@section('title', 'Icons')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Icons</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">UI Elements</a></li>
                <li class="breadcrumb-item active" aria-current="page">Icons</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- The icons --}}
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Icons</h3>
                    </div>
                    <div class="card-body">
                        <p>You can use any font library you like with AdminLTE 4.</p>
                        <strong>Recommendations</strong>
                        <ul class="mt-1">
                            <li>
                                <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">
                                    Bootstrap Icons
                                </a>
                                (bundled and used throughout this template)
                            </li>
                            <li>
                                <a href="https://fontawesome.com/" target="_blank" rel="noopener noreferrer">Font Awesome</a>
                            </li>
                            <li>
                                <a href="https://useiconic.com/open/" target="_blank" rel="noopener noreferrer">Iconic Icons</a>
                            </li>
                            <li>
                                <a href="https://ionicons.com/" target="_blank" rel="noopener noreferrer">Ion Icons</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Bootstrap Icons</h3>
                </div>
                <div class="card-body">
                    <p>
                        A small sample of the
                        <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">Bootstrap Icons</a>
                        set. Use them anywhere with the <code>bi bi-*</code> classes.
                    </p>
                    <div class="row g-3 text-center">
                        @php
                            $icons = [
                                'house', 'speedometer2', 'person', 'people', 'gear', 'bell',
                                'envelope', 'chat-dots', 'calendar', 'clock', 'star', 'heart',
                                'bookmark', 'flag', 'tag', 'cart', 'bag', 'box',
                                'file-earmark', 'folder', 'cloud', 'download', 'upload', 'trash',
                                'pencil', 'check-circle', 'x-circle', 'search', 'camera', 'image',
                            ];
                        @endphp
                        @foreach ($icons as $icon)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="border rounded p-3 h-100">
                                    <i class="bi bi-{{ $icon }} fs-2 d-block mb-2"></i>
                                    <small class="text-muted d-block text-truncate">bi bi-{{ $icon }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@stop
