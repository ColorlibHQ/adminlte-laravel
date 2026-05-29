@extends('adminlte::page')

@section('title', __('adminlte.chat'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">{{ __('adminlte.chat') }}</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('adminlte.pages') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.chat') }}</li>
            </ol>
        </div>
    </div>
@stop

@push('css')
    <style>
        .chat-app {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 0;
            height: calc(100vh - 14rem);
            min-height: 32rem;
            border-radius: var(--bs-border-radius);
            overflow: hidden;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
        }
        @media (max-width: 768px) {
            .chat-app {
                grid-template-columns: 1fr;
            }
        }
        .chat-contacts {
            background: var(--bs-tertiary-bg);
            border-right: 1px solid var(--bs-border-color);
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        .chat-contact {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid var(--bs-border-color);
            text-decoration: none;
            color: inherit;
        }
        .chat-contact:hover {
            background: var(--bs-body-bg);
        }
        .chat-contact.active {
            background: var(--bs-body-bg);
            border-left: 3px solid var(--bs-primary);
            padding-left: calc(1rem - 3px);
        }
        .chat-avatar {
            position: relative;
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .chat-avatar.online::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background: var(--bs-success);
            border: 2px solid var(--bs-body-bg);
            border-radius: 50%;
        }
        .chat-conversation {
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        .chat-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--bs-border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: var(--bs-tertiary-bg);
        }
        .chat-message {
            display: flex;
            margin-bottom: 0.75rem;
            gap: 0.5rem;
            align-items: flex-end;
        }
        .chat-message.me {
            flex-direction: row-reverse;
        }
        .chat-message .chat-avatar {
            width: 32px;
            height: 32px;
        }
        .chat-body {
            max-width: 70%;
        }
        .chat-meta {
            font-size: 0.75rem;
            margin-bottom: 0.15rem;
        }
        .chat-message.me .chat-meta {
            text-align: right;
        }
        .chat-bubble {
            padding: 0.5rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .chat-message.them .chat-bubble {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-bottom-left-radius: 0.25rem;
        }
        .chat-message.me .chat-bubble {
            background: var(--bs-primary);
            color: #fff;
            border-bottom-right-radius: 0.25rem;
        }
        .chat-time {
            font-size: 0.7rem;
            opacity: 0.7;
            display: block;
            margin-top: 0.15rem;
        }
        .chat-composer {
            padding: 0.75rem;
            border-top: 1px solid var(--bs-border-color);
        }
        .chat-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--bs-secondary-color);
            text-align: center;
            padding: 2rem;
        }
    </style>
@endpush

@section('content')
    @php
        $avatars = [
            asset('vendor/adminlte/img/user1-128x128.jpg'),
            asset('vendor/adminlte/img/user2-160x160.jpg'),
            asset('vendor/adminlte/img/user3-128x128.jpg'),
            asset('vendor/adminlte/img/user8-128x128.jpg'),
        ];
        $avatarFor = fn ($id) => $avatars[(int) $id % count($avatars)];
    @endphp

    <div class="chat-app">
        {{-- Contacts / conversations sidebar --}}
        <aside class="chat-contacts">
            <div class="p-3 border-bottom">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-body">
                        <i class="bi bi-search" aria-hidden="true"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="{{ __('adminlte.search') }}…"
                           aria-label="{{ __('adminlte.search') }}">
                </div>
            </div>
            <div class="flex-grow-1 overflow-auto">
                @forelse ($conversations as $conversation)
                    @php($partner = $conversation->users->firstWhere('id', '!=', auth()->id()))
                    <a href="{{ route('adminlte.chat.show', $conversation) }}"
                       class="chat-contact {{ $active && $active->id === $conversation->id ? 'active' : '' }}">
                        <img class="chat-avatar online" src="{{ $avatarFor($partner->id ?? $conversation->id) }}"
                             alt="{{ $partner->name ?? __('adminlte.conversation') }}">
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 text-truncate fw-semibold">
                                    {{ $partner->name ?? ($conversation->name ?? __('adminlte.conversation')) }}
                                </p>
                                <small class="text-secondary flex-shrink-0 ms-2">
                                    {{ $conversation->latestMessage?->created_at?->diffForHumans(null, true) }}
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-truncate text-secondary">
                                    {{ $conversation->latestMessage?->body }}
                                </small>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-3 text-secondary small">{{ __('adminlte.no_conversations') }}</div>
                @endforelse
            </div>
        </aside>

        {{-- Conversation pane --}}
        <section class="chat-conversation">
            @if (!$active)
                <div class="chat-empty">
                    <i class="bi bi-chat-dots" style="font-size: 2.5rem" aria-hidden="true"></i>
                    <p class="mt-2 mb-0">{{ __('adminlte.select_conversation') }}</p>
                </div>
            @else
                @php($activePartner = $active->users->firstWhere('id', '!=', auth()->id()))
                <header class="chat-header">
                    <img class="chat-avatar online" src="{{ $avatarFor($activePartner->id ?? $active->id) }}"
                         alt="{{ $activePartner->name ?? __('adminlte.conversation') }}">
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-semibold">
                            {{ $activePartner->name ?? ($active->name ?? __('adminlte.conversation')) }}
                        </p>
                        <small class="text-success">
                            <i class="bi bi-circle-fill" style="font-size: 0.5rem" aria-hidden="true"></i>
                            {{ __('adminlte.online') }}
                        </small>
                    </div>
                </header>

                <div class="chat-messages" id="chat-messages">
                    @foreach ($active->messages as $msg)
                        @php($mine = $msg->user_id === auth()->id())
                        <div class="chat-message {{ $mine ? 'me' : 'them' }}">
                            <img class="chat-avatar" src="{{ $avatarFor($msg->user_id) }}"
                                 alt="{{ $msg->user->name }}">
                            <div class="chat-body">
                                <div class="chat-meta text-secondary">
                                    <span class="fw-semibold">{{ $msg->user->name }}</span>
                                </div>
                                <div class="chat-bubble">
                                    {{ $msg->body }}
                                    <span class="chat-time">{{ $msg->created_at->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form class="chat-composer" method="POST" action="{{ route('adminlte.chat.store', $active) }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="body" class="form-control"
                               placeholder="{{ __('adminlte.type_message') }}"
                               aria-label="{{ __('adminlte.type_message') }}" required>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send me-1" aria-hidden="true"></i>{{ __('adminlte.send') }}
                        </button>
                    </div>
                </form>
            @endif
        </section>
    </div>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const list = document.getElementById('chat-messages');
            if (list) {
                list.scrollTop = list.scrollHeight;
            }
        });
    </script>
@endpush
