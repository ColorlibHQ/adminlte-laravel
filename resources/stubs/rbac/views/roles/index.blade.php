@extends('adminlte::page')

@section('title', __('adminlte.roles'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.roles') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('adminlte.administration') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.roles') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-shield-lock" title="{{ __('adminlte.roles') }}" bodyClass="p-0">
        <x-slot name="tools">
            <a href="{{ route('adminlte.roles.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> {{ __('adminlte.new_role') }}
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>{{ __('adminlte.name') }}</th>
                        <th>{{ __('adminlte.label') }}</th>
                        <th>{{ __('adminlte.permissions') }}</th>
                        <th class="text-end">{{ __('adminlte.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td class="text-muted">{{ $role->label ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $role->permissions_count }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('adminlte.roles.edit', $role) }}"
                                   class="btn btn-sm btn-outline-secondary" aria-label="{{ __('adminlte.edit') }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('adminlte.roles.destroy', $role) }}"
                                      onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="{{ __('adminlte.delete') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">{{ __('adminlte.no_roles') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            {{ $roles->links() }}
        </x-slot>
    </x-adminlte-card>
@stop
