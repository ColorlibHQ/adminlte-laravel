@extends('adminlte::page')

@section('title', $title.' — Documentation')

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h1 class="m-0">{{ $title }}</h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('docs') }}">Docs</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card mb-4 adminlte-docs-nav">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-book me-1"></i> Documentation</h3>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($nav as $slug => $label)
                        <a href="{{ url('docs/'.$slug) }}"
                           class="list-group-item list-group-item-action {{ $current === $slug ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card mb-4">
                <div class="card-body">
                    <article class="adminlte-docs">{!! $html !!}</article>
                </div>
            </div>
        </div>
    </div>
@stop

@once
    <style>
        .adminlte-docs { line-height: 1.65; }
        .adminlte-docs h1, .adminlte-docs h2, .adminlte-docs h3,
        .adminlte-docs h4 { margin-top: 1.75rem; margin-bottom: .75rem; font-weight: 600; }
        .adminlte-docs h1:first-child, .adminlte-docs h2:first-child { margin-top: 0; }
        .adminlte-docs h2 { padding-bottom: .3rem; border-bottom: 1px solid var(--bs-border-color); }
        .adminlte-docs p, .adminlte-docs ul, .adminlte-docs ol { margin-bottom: 1rem; }
        .adminlte-docs table { width: 100%; margin-bottom: 1rem; border-collapse: collapse; }
        .adminlte-docs th, .adminlte-docs td {
            padding: .5rem .75rem; border: 1px solid var(--bs-border-color); vertical-align: top; }
        .adminlte-docs thead th { background: var(--bs-tertiary-bg); }
        .adminlte-docs code {
            background: var(--bs-tertiary-bg); padding: .15rem .4rem; border-radius: .25rem;
            font-size: .875em; }
        .adminlte-docs pre {
            background: var(--bs-tertiary-bg); padding: 1rem; border-radius: .5rem;
            overflow: auto; margin-bottom: 1rem; }
        .adminlte-docs pre code { background: none; padding: 0; }
        .adminlte-docs blockquote {
            border-left: 4px solid var(--bs-primary); padding: .25rem 0 .25rem 1rem;
            color: var(--bs-secondary-color); margin: 0 0 1rem; }
        .adminlte-docs img { max-width: 100%; }
        .adminlte-docs-nav .list-group-item.active { font-weight: 600; }
    </style>
@endonce
