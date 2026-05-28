@extends('adminlte::auth.auth-master', ['authType' => 'login'])

@section('auth_body')
    <p class="login-box-msg">{{ __('adminlte.sign_in_to_start_session') }}</p>

    <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="form-floating mb-3">
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   placeholder="{{ __('adminlte.email') }}" required autofocus>
            <label for="email">{{ __('adminlte.email') }}</label>
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   id="password"
                   placeholder="{{ __('adminlte.password') }}" required>
            <label for="password">{{ __('adminlte.password') }}</label>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="row mb-3">
            <div class="col-8">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">{{ __('adminlte.remember_me') }}</label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary w-100">{{ __('adminlte.sign_in') }}</button>
            </div>
        </div>
    </form>

    @if (Route::has('password.request'))
        <p class="mb-1 mt-3">
            <a href="{{ route('password.request') }}">{{ __('adminlte.i_forgot_my_password') }}</a>
        </p>
    @endif
    @if (Route::has('register'))
        <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">{{ __('adminlte.register_new_membership') }}</a>
        </p>
    @endif
@endsection
