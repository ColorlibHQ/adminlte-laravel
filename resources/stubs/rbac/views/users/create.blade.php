@extends('adminlte::page')

@section('title', __('adminlte.new_user'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.new_user') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('adminlte.administration') }}</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.users.index') }}">{{ __('adminlte.users') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.create') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-person-plus" title="{{ __('adminlte.new_user') }}">
        <form method="POST" action="{{ route('adminlte.users.store') }}">
            @csrf

            <x-adminlte-input name="name" label="{{ __('adminlte.name') }}" required />
            <x-adminlte-input name="email" type="email" label="{{ __('adminlte.email') }}" required />

            <div class="mb-3">
                <label class="form-label">{{ __('adminlte.roles') }}</label>
                @error('roles')
                    <div class="text-danger small mb-1">{{ $message }}</div>
                @enderror
                <div class="row">
                    @forelse ($roles as $role)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]"
                                       value="{{ $role->id }}" id="role-{{ $role->id }}"
                                       @checked(in_array($role->id, old('roles', [])))>
                                <label class="form-check-label" for="role-{{ $role->id }}">
                                    {{ $role->label ?? $role->name }}
                                </label>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('adminlte.no_roles') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('adminlte.users.index') }}" class="btn btn-outline-secondary">{{ __('adminlte.cancel') }}</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> {{ __('adminlte.save') }}
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
