@php
    $title = trim($title ?? config('adminlte.title', 'AdminLTE 4'));

    $user = auth()->user();
    $name = $user->name;
    $avatar = !empty($user?->profile_photo_url)
        ? $user->profile_photo_url
        : asset('vendor/adminlte/img/user2-160x160.jpg');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token">
        <title>{{ $title }}</title>
        {{-- Bootstrap Icons ship via the Vite bundle (imported in resources/css/adminlte.css) --}}
        @vite(['resources/css/adminlte.css', 'resources/js/adminlte.js'])
        @stack('css')
    </head>

    <body class="lockscreen bg-body-secondary app-loaded">
        <main class="lockscreen-wrapper" id="main" tabindex="-1">
            <h1 class="lockscreen-logo">
                <a href="../index2.html">
                    @if (config('adminlte.auth_logo.enabled', false))
                        <img @if (config('adminlte.auth_logo.img.class', null)) class="{{ config('adminlte.auth_logo.img.class') }}" @endif
                            @if (config('adminlte.auth_logo.img.width', null)) width="{{ config('adminlte.auth_logo.img.width') }}" @endif
                            @if (config('adminlte.auth_logo.img.height', null)) height="{{ config('adminlte.auth_logo.img.height') }}" @endif
                            alt="{{ config('adminlte.auth_logo.img.alt') }}"
                            src="{{ asset(config('adminlte.auth_logo.img.path')) }}">
                    @else
                        <img alt="{{ config('adminlte.logo_img_alt') }}" height="50"
                            src="{{ asset(config('adminlte.logo_img')) }}">
                    @endif
                    {!! config('adminlte.logo') !!}
                </a>
            </h1>

            <div class="lockscreen-name">{{ $name }}</div>

            <div class="lockscreen-item">
                <div class="lockscreen-image">
                    <img alt="John Doe" src="{{ $avatar }}">
                </div>

                <form action="{{ route('password.confirm') }}" class="lockscreen-credentials" method="post">
                    @csrf
                    <label class="visually-hidden" for="lockscreenPassword">{{ __('adminlte.password') }}</label>

                    <div class="input-group">
                        <input class="form-control @error('password') is-invalid @enderror" id="lockscreenPassword"
                            inputmode="numeric" name="password" placeholder="{{ __('adminlte.password') }}" required
                            type="password">

                        <div class="input-group-text border-0 bg-transparent px-1">
                            <button aria-label="{{ __('adminlte.sign_in') }}" class="btn shadow-none" type="submit">
                                <i class="bi bi-box-arrow-right text-body-secondary"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ __($message) }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="help-block text-center">{{ __('adminlte.confirm_password_message') }}</div>
            <div class="text-center">
                <a class="text-decoration-none"
                    href="{{ route('login') }}">{{ __('adminlte.sign_in_as_different_user') }}</a>
            </div>
            <div class="lockscreen-footer text-center">
                {!! config('adminlte.footer_left') !!}
            </div>
        </main>

        @stack('js')
    </body>

</html>
