@extends('adminlte::auth.auth-master', ['authType' => 'lockscreen'])

@section('auth_body')
    <div class="lockscreen-wrapper">
        <div class="text-center mb-4">
            @if (auth()->check())
                @php $user = auth()->user(); @endphp
                <div class="mb-3">
                    <img src="https://placehold.co/80x80" alt="{{ $user->name }}" class="rounded-circle">
                </div>
                <p class="fs-5 fw-bold">{{ $user->name }}</p>
            @endif
        </div>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="{{ __('adminlte.password') }}"
                       inputmode="numeric"
                       maxlength="6"
                       required>
                <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">{{ __('adminlte.unlock') ?? 'Unlock' }}</button>
        </form>

        @if (Route::has('login'))
            <p class="text-center mt-3">
                <a href="{{ route('login') }}">{{ __('adminlte.sign_in_as_different_user') ?? 'Sign in as a different user' }}</a>
            </p>
        @endif
    </div>
@endsection
