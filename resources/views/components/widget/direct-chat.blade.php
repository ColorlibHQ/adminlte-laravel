<div class="card" data-lte-toggle="chat-pane">
    <div class="card-header border-0">
        @if ($title)
            <h3 class="card-title">{{ $title }}</h3>
        @endif
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-lte-toggle="chat-pane">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="direct-chat direct-chat-primary">
            <div class="direct-chat-messages">
                @forelse ($items as $item)
                    <div class="direct-chat-msg @if ($item['is_own'] ?? false) right @endif">
                        @if (!($item['is_own'] ?? false))
                            <img class="direct-chat-img" src="{{ $item['avatar'] ?? 'https://placehold.co/40x40' }}" alt="Message user image">
                        @endif
                        <div class="direct-chat-text">
                            {{ $item['message'] ?? '' }}
                        </div>
                        @if ($item['is_own'] ?? false)
                            <img class="direct-chat-img" src="{{ $item['avatar'] ?? 'https://placehold.co/40x40' }}" alt="Message user image">
                        @endif
                    </div>
                @empty
                    <p class="text-muted">{{ __('adminlte.no_messages') ?? 'No messages' }}</p>
                @endforelse
            </div>
            <div class="direct-chat-contacts">
                {{ $slot }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <form action="#" method="post">
            <div class="input-group">
                <input type="text" name="message" placeholder="{{ __('adminlte.type_message') ?? 'Type message...' }}" class="form-control">
                <span class="input-group-append">
                    <button type="button" class="btn btn-primary">Send</button>
                </span>
            </div>
        </form>
    </div>
</div>
