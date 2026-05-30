@extends('adminlte::auth.auth-master', ['authType' => 'login'])

@section('auth_body')
    <p class="login-box-msg">{{ __('adminlte.confirm_password_message') }}</p>

    <form action="{{ route('password.confirm') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('adminlte.password') }}" required autofocus autocomplete="current-password">
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('adminlte.confirm') }}</button>
    </form>
@endsection
