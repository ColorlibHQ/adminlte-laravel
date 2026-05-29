@extends('adminlte::page')

@section('title', __('adminlte.calendar'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.calendar') }}</h1>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-calendar3" title="{{ __('adminlte.events') }}">
        <x-adminlte-calendar :events="route('adminlte.calendar.feed')" height="650px" />
    </x-adminlte-card>
@stop
