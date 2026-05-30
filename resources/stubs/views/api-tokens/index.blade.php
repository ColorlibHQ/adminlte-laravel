@extends('adminlte::page')

@section('title', __('adminlte.api_tokens'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.api_tokens') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    @if (session('token_plain'))
        <x-adminlte-alert theme="warning">
            <strong>{{ __('adminlte.token_copy_now') }}</strong>
            <pre class="mt-2 mb-0 p-2 bg-body-tertiary rounded user-select-all">{{ session('token_plain') }}</pre>
        </x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-md-5">
            <x-adminlte-card icon="bi bi-key" title="{{ __('adminlte.new_token') }}">
                <form action="{{ route('adminlte.api-tokens.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('adminlte.token_name') }}</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. CI deploy" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> {{ __('adminlte.create') }}
                    </button>
                </form>
            </x-adminlte-card>
        </div>

        <div class="col-md-7">
            <x-adminlte-card icon="bi bi-shield-lock" title="{{ __('adminlte.api_tokens') }}" bodyClass="p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle m-0">
                        <thead>
                            <tr>
                                <th>{{ __('adminlte.token_name') }}</th>
                                <th>{{ __('adminlte.last_used') }}</th>
                                <th class="text-end">{{ __('adminlte.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tokens as $token)
                                <tr>
                                    <td><strong>{{ $token->name }}</strong></td>
                                    <td class="text-secondary">
                                        {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : __('adminlte.never') }}
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('adminlte.api-tokens.destroy', $token->id) }}" method="post"
                                              onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i> {{ __('adminlte.revoke') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-secondary py-4">{{ __('adminlte.no_tokens') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
