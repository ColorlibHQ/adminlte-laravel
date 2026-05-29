@extends('adminlte::layouts.errors-master')

@section('title', '404 Not Found')

@section('content')
    <div class="text-center">
        <h1 class="display-1 fw-bold text-dark">404</h1>
        <p class="fs-3"><span class="text-danger">{{ __('adminlte.oops') ?? 'Oops!' }}</span> {{ __('adminlte.page_not_found') ?? 'Page not found.' }}</p>
        <p class="lead">{{ __('adminlte.page_not_found_message') ?? 'The page you are looking for might have been removed had its name changed or is temporarily unavailable.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">{{ __('adminlte.go_home') ?? 'Go Home' }}</a>
    </div>
@endsection
