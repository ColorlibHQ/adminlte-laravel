@extends('adminlte::page')

@section('title', __('adminlte.edit_role'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.edit_role') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('adminlte.administration') }}</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.roles.index') }}">{{ __('adminlte.roles') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.edit') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-shield-lock" title="{{ __('adminlte.edit_role') }}">
        <form method="POST" action="{{ route('adminlte.roles.update', $role) }}">
            @csrf
            @method('PUT')

            <x-adminlte-input name="name" label="{{ __('adminlte.name') }}" :value="$role->name" required />
            <x-adminlte-input name="label" label="{{ __('adminlte.label') }}" :value="$role->label" />

            <div class="mb-3">
                <label class="form-label">{{ __('adminlte.permissions') }}</label>
                @error('permissions')
                    <div class="text-danger small mb-1">{{ $message }}</div>
                @enderror
                <div class="row">
                    @forelse ($permissions as $permission)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                       value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                       @checked(in_array($permission->id, old('permissions', $role->permissions->pluck('id')->all())))>
                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                    {{ $permission->label ?? $permission->name }}
                                </label>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('adminlte.no_permissions') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('adminlte.roles.index') }}" class="btn btn-outline-secondary">{{ __('adminlte.cancel') }}</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> {{ __('adminlte.save') }}
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
