@extends('adminlte::page')
@section('title', __('adminlte.inbox'))
@section('content_header')
    <div class="row"><div class="col-sm-6"><h1>{{ __('adminlte.inbox') }}</h1></div></div>
@stop
@section('content')
    <div class="row"><div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary btn-sm">{{ __('adminlte.compose') }}</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <tbody>
                        @for ($i = 1; $i <= 5; $i++)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><strong>Message {{ $i }}</strong></td>
                                <td class="text-muted small">5 minutes ago</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
@stop
