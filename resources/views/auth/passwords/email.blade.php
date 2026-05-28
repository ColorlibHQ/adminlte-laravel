@extends('adminlte::auth.auth-master', ['authType' => 'login'])

@section('auth_body')
    <p class="login-box-msg">{{ __('adminlte.you_forgot_password') }}</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="{{ __('adminlte.email') }}" required autofocus>
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('adminlte.request_new_password') }}</button>
    </form>

    <p class="mb-0 mt-3">
        <a href="{{ route('login') }}" class="text-center">{{ __('adminlte.login') }}</a>
    </p>
@endsection
