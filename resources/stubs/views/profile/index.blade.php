@extends('adminlte::page')

@section('title', __('adminlte.profile'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.profile') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid rounded-circle mb-2" src="https://placehold.co/100x100" alt="{{ __('adminlte.profile') }}">
                    <h3 class="profile-username">{{ $user->name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>
                    <ul class="list-group list-group-unbordered mb-0 text-start">
                        <li class="list-group-item d-flex justify-content-between">
                            <b>{{ __('adminlte.member_since') }}</b>
                            <span>{{ $user->created_at?->format('M Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <x-adminlte-card>
                <x-adminlte-tabs>
                    <x-adminlte-tab id="profile-info" title="{{ __('adminlte.activity') }}" :active="true">
                        <p class="text-muted">{{ __('adminlte.no_recent_activity') }}</p>
                    </x-adminlte-tab>
                    <x-adminlte-tab id="profile-edit" title="{{ __('adminlte.edit') }}">
                        <form method="POST" action="{{ route('adminlte.profile.update') }}">
                            @csrf
                            @method('PUT')
                            <x-adminlte-input name="name" label="{{ __('adminlte.name') }}" value="{{ $user->name }}" required />
                            <x-adminlte-input name="email" type="email" label="{{ __('adminlte.email') }}" value="{{ $user->email }}" required />
                            <button type="submit" class="btn btn-primary">{{ __('adminlte.save') }}</button>
                        </form>
                    </x-adminlte-tab>
                </x-adminlte-tabs>
            </x-adminlte-card>
        </div>
    </div>
@stop
