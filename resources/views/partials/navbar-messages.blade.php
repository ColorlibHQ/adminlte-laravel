@php
    // Demo messages for the navbar dropdown. Replace with real data in your app.
    $messages = config('adminlte.navbar_messages', [
        ['name' => 'Brad Diesel', 'text' => 'Call me whenever you can...', 'time' => '4 Hours Ago', 'star' => 'danger', 'img' => 'vendor/adminlte/img/user1-128x128.jpg'],
        ['name' => 'John Pierce', 'text' => 'I got your message bro', 'time' => '4 Hours Ago', 'star' => 'secondary', 'img' => 'vendor/adminlte/img/user8-128x128.jpg'],
        ['name' => 'Nora Silvester', 'text' => 'The subject goes here', 'time' => '4 Hours Ago', 'star' => 'warning', 'img' => 'vendor/adminlte/img/user3-128x128.jpg'],
    ]);
@endphp
<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-chat-text"></i>
        <span class="navbar-badge badge text-bg-danger">{{ count($messages) }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        @foreach ($messages as $msg)
            <a href="#" class="dropdown-item">
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
        @endforeach
        <a href="#" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_messages') }}</a>
    </div>
</li>
