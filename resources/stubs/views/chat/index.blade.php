@extends('adminlte::page')

@section('title', __('adminlte.chat'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.chat') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-card title="{{ __('adminlte.conversations') }}" icon="bi bi-chat-dots" bodyClass="p-0">
                <div class="list-group list-group-flush">
                    @forelse ($conversations as $conversation)
                        @php($partner = $conversation->users->firstWhere('id', '!=', auth()->id()))
                        <a href="{{ route('adminlte.chat.show', $conversation) }}"
                           class="list-group-item list-group-item-action {{ $active && $active->id === $conversation->id ? 'active' : '' }}">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $partner->name ?? ($conversation->name ?? __('adminlte.conversation')) }}</strong>
                                <small>{{ $conversation->latestMessage?->created_at?->diffForHumans() }}</small>
                            </div>
                            <div class="text-truncate small">{{ $conversation->latestMessage?->body }}</div>
                        </a>
                    @empty
                        <div class="list-group-item text-muted">{{ __('adminlte.no_conversations') }}</div>
                    @endforelse
                </div>
            </x-adminlte-card>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('adminlte.messages') }}</h3>
                </div>
                <div class="card-body">
                    @if ($active)
                        <div class="direct-chat-messages" style="height: 400px;">
                            @foreach ($active->messages as $msg)
                                @php($mine = $msg->user_id === auth()->id())
                                <div class="direct-chat-msg {{ $mine ? 'end' : '' }}">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-{{ $mine ? 'end' : 'start' }}">{{ $msg->user->name }}</span>
                                        <span class="direct-chat-timestamp float-{{ $mine ? 'start' : 'end' }}">{{ $msg->created_at->format('H:i') }}</span>
                                    </div>
                                    <img class="direct-chat-img" src="https://placehold.co/40x40" alt="avatar">
                                    <div class="direct-chat-text">{{ $msg->body }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center m-0">{{ __('adminlte.select_conversation') }}</p>
                    @endif
                </div>
                @if ($active)
                    <div class="card-footer">
                        <form method="POST" action="{{ route('adminlte.chat.store', $active) }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="body" class="form-control" placeholder="{{ __('adminlte.type_message') }}" required>
                                <button type="submit" class="btn btn-primary">{{ __('adminlte.send') }}</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
