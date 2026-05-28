@extends('adminlte::auth.auth-master', ['authType' => 'register'])

@section('auth_body')
    <p class="login-box-msg">{{ __('adminlte.register_new_membership') }}</p>

    <form action="{{ route('register') }}" method="post">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   placeholder="{{ __('adminlte.full_name') }}" required autofocus>
            <label for="name">{{ __('adminlte.full_name') }}</label>
            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="form-floating mb-3">
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   placeholder="{{ __('adminlte.email') }}" required>
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

        <div class="form-floating mb-3">
            <input type="password" name="password_confirmation"
                   class="form-control"
                   id="password_confirmation"
                   placeholder="{{ __('adminlte.confirm_password') }}" required>
            <label for="password_confirmation">{{ __('adminlte.confirm_password') }}</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('adminlte.register') }}</button>

        @if (Route::has('login'))
            <p class="mb-0 mt-3">
                <a href="{{ route('login') }}" class="text-center">{{ __('adminlte.i_already_have_membership') }}</a>
            </p>
        @endif
    </form>
@endsection
