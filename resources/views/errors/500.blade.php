@extends('adminlte::layouts.errors-master')

@section('title', '500 Server Error')

@section('content')
    <div class="text-center">
        <h1 class="display-1 fw-bold text-danger">500</h1>
        <p class="fs-3"><span class="text-danger">{{ __('adminlte.oops') ?? 'Oops!' }}</span> {{ __('adminlte.server_error') ?? 'Something went wrong.' }}</p>
        <p class="lead">{{ __('adminlte.server_error_message') ?? 'We are sorry, but an error occurred on the server side.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">{{ __('adminlte.go_home') ?? 'Go Home' }}</a>
    </div>
@endsection
