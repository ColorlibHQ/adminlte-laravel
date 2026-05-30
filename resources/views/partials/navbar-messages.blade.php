@php
    use ColorlibHQ\AdminLte\Support\NavbarData;

    // Real unread mailbox messages when the `adminlte_messages` table exists,
    // otherwise the config-driven demo data. See NavbarData for the logic.
    $messages = NavbarData::messages();
    $messageCount = NavbarData::messageCount();
    $messagesUrl = \Illuminate\Support\Facades\Route::has('adminlte.mailbox.index')
        ? route('adminlte.mailbox.index')
        : '#';
@endphp
<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-chat-text"></i>
        @if ($messageCount > 0)
            <span class="navbar-badge badge text-bg-danger">{{ $messageCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        @forelse ($messages as $msg)
            <a href="{{ $messagesUrl }}" class="dropdown-item">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="{{ asset($msg['img']) }}" alt="User Avatar" class="img-size-50 rounded-circle me-3" width="50" height="50">
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="dropdown-item-title">
                            {{ $msg['name'] }}
                            <span class="float-end fs-7 text-{{ $msg['star'] }}"><i class="bi bi-star-fill"></i></span>
                        </h3>
                        <p class="fs-7">{{ $msg['text'] }}</p>
                        <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> {{ $msg['time'] }}</p>
                    </div>
                </div>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <span class="dropdown-item text-secondary">{{ __('adminlte.no_messages') }}</span>
            <div class="dropdown-divider"></div>
        @endforelse
        <a href="{{ $messagesUrl }}" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_messages') }}</a>
    </div>
</li>
