@extends('adminlte::page')

@section('title', __('adminlte.profile'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h1>{{ __('adminlte.profile') }}</h1></div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="https://placehold.co/100x100" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ auth()->user()?->name ?? 'User' }}</h3>
                    <p class="text-muted text-center">{{ __('adminlte.profile') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-bs-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-bs-toggle="tab">Settings</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="activity">
                            <strong>{{ __('adminlte.loading') }}</strong>
                        </div>
                        <div class="tab-pane" id="settings">
                            <strong>{{ __('adminlte.loading') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
