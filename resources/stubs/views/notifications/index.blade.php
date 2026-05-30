@extends('adminlte::page')

@section('title', __('adminlte.notifications'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">{{ __('adminlte.notifications') }}</h1>
        @if ($notifications->total() > 0)
            <form method="POST" action="{{ route('adminlte.notifications.read-all') }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-check2-all me-1"></i> {{ __('adminlte.mark_all_as_read') }}
                </button>
            </form>
        @endif
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-bell" title="{{ __('adminlte.notifications') }}" bodyClass="p-0">
        <div class="list-group list-group-flush">
            @forelse ($notifications as $notification)
                <div class="list-group-item d-flex align-items-start gap-3 {{ $notification->read_at ? '' : 'bg-body-secondary' }}">
                    <i class="{{ $notification->data['icon'] ?? 'bi bi-bell-fill' }} fs-4 text-primary mt-1"></i>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $notification->data['title'] ?? __('adminlte.notifications') }}</div>
                        <div class="text-secondary">{{ $notification->data['message'] ?? '' }}</div>
                        <small class="text-secondary"><i class="bi bi-clock me-1"></i>{{ $notification->created_at?->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex gap-1">
                        @if (! $notification->read_at)
                            <form method="POST" action="{{ route('adminlte.notifications.read', $notification->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ __('adminlte.mark_as_read') }}">
                                    <i class="bi bi-check2"></i>
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('adminlte.notifications.destroy', $notification->id) }}"
                              onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('adminlte.delete') }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="list-group-item text-center text-secondary py-5">
                    <i class="bi bi-bell-slash fs-1 d-block mb-2"></i>
                    {{ __('adminlte.no_notifications') }}
                </div>
            @endforelse
        </div>
    </x-adminlte-card>

    @if ($notifications->hasPages())
        <div class="mt-3">{{ $notifications->links() }}</div>
    @endif
@stop
