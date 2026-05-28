@extends('adminlte::auth.auth-master', ['authType' => 'login'])

@section('auth_body')
    <p class="login-box-msg">{{ __('You are only one step away from your new password, recover your password now.') }}</p>

    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}">

        <div class="input-group mb-3">
            <input type="email" name="email" value="{{ old('email', $email ?? '') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="{{ __('Email') }}" required autofocus>
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('Password') }}" required>
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="{{ __('Confirm password') }}" required>
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('Change password') }}</button>
    </form>
@endsection
