@extends('adminlte::page')

@section('title', $message->subject)

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.read_mail') }}</h1>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-envelope-open" title="{{ $message->subject }}">
        <x-slot name="tools">
            <a href="{{ route('adminlte.mailbox.index') }}" class="btn btn-tool" aria-label="{{ __('adminlte.back') }}">
                <i class="bi bi-arrow-left"></i>
            </a>
        </x-slot>

        <div class="mailbox-read-info border-bottom pb-3 mb-3">
            <h5 class="mb-1">{{ $message->subject }}</h5>
            <h6 class="text-muted">
                {{ __('adminlte.from') }}: {{ $message->sender->name ?? __('adminlte.unknown') }}
                <span class="float-end small">{{ $message->created_at->format('d M Y, H:i') }}</span>
            </h6>
        </div>

        <div class="mailbox-read-message">
            {!! nl2br(e($message->body)) !!}
        </div>

        <x-slot name="footer">
            <div class="d-flex gap-2">
                <a href="{{ route('adminlte.mailbox.create') }}" class="btn btn-primary">
                    <i class="bi bi-reply me-1"></i> {{ __('adminlte.reply') }}
                </a>
                <form method="POST" action="{{ route('adminlte.mailbox.destroy', $message) }}"
                      onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> {{ __('adminlte.delete_message') }}
                    </button>
                </form>
            </div>
        </x-slot>
    </x-adminlte-card>
@stop
