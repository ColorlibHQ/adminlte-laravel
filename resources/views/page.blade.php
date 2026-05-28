{{--
    The primary layout most apps extend:

        @extends('adminlte::page')

        @section('title', 'Dashboard')
        @section('content_header')
            <h3 class="mb-0">Dashboard</h3>
        @stop
        @section('content')
            ...your page...
        @stop
--}}
@extends('adminlte::master')

@section('adminlte_css')
    @stack('adminlte_css')
@stop
