@extends('adminlte::auth.auth-master', ['authType' => 'login'])

@section('auth_body')
    <p class="login-box-msg">{{ __('adminlte.verify_email_message') }}</p>

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success">{{ __('adminlte.verification_link_sent') }}</div>
    @endif

    <form action="{{ route('verification.send') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="bi bi-envelope-arrow-up me-1" aria-hidden="true"></i> {{ __('adminlte.resend_verification') }}
        </button>
    </form>

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-link p-0">{{ __('adminlte.sign_out') }}</button>
    </form>
@endsection
