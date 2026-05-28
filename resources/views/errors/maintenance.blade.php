@extends('adminlte::layouts.errors-master')

@section('title', 'Maintenance Mode')

@section('content')
    <div class="text-center">
        <h1 class="display-1 fw-bold text-warning">⚠️</h1>
        <p class="fs-3">{{ __('adminlte.maintenance_mode') ?? 'Maintenance Mode' }}</p>
        <p class="lead">{{ __('adminlte.maintenance_message') ?? 'We are currently performing maintenance. Please check back soon!' }}</p>
    </div>
@endsection
