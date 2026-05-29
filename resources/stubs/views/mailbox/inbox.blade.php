@extends('adminlte::page')

@section('title', __('adminlte.inbox'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.inbox') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('adminlte.mailbox.create') }}" class="btn btn-primary btn-block mb-3 w-100">
                <i class="bi bi-pencil-square me-1"></i> {{ __('adminlte.compose') }}
            </a>
            <x-adminlte-card title="{{ __('adminlte.folders') }}" theme="" :collapsible="false">
                <div class="list-group list-group-flush">
                    <a href="{{ route('adminlte.mailbox.index') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-inbox me-2"></i> {{ __('adminlte.inbox') }}
                        <span class="badge bg-primary float-end">{{ $messages->total() }}</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="bi bi-star me-2"></i> {{ __('adminlte.starred') }}
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="bi bi-send me-2"></i> {{ __('adminlte.sent') }}
                    </a>
                </div>
            </x-adminlte-card>
        </div>

        <div class="col-md-9">
            <x-adminlte-card title="{{ __('adminlte.inbox') }}" icon="bi bi-envelope">
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <tbody>
                            @forelse ($messages as $message)
                                <tr class="{{ $message->is_read ? '' : 'fw-bold' }}">
                                    <td style="width: 2rem;">
                                        @if ($message->is_starred)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-muted"></i>
                                        @endif
                                    </td>
                                    <td style="width: 12rem;">
                                        <a href="{{ route('adminlte.mailbox.show', $message) }}" class="text-body text-decoration-none">
                                            {{ $message->sender->name ?? __('adminlte.unknown') }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('adminlte.mailbox.show', $message) }}" class="text-body text-decoration-none">
                                            {{ $message->subject }}
                                        </a>
                                    </td>
                                    <td class="text-muted small text-end" style="width: 8rem;">
                                        {{ $message->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="text-center text-muted py-4">{{ __('adminlte.no_messages') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-slot name="footer">
                    {{ $messages->links() }}
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>
@stop
