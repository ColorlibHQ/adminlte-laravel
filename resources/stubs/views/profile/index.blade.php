@extends('adminlte::page')

@section('title', __('adminlte.profile'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.profile') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row">
        {{-- Avatar / summary card --}}
        <div class="col-lg-4">
            <x-adminlte-card>
                <div class="text-center">
                    @php($avatar = $user->avatar ?? null)
                    <img src="{{ $avatar ? \Illuminate\Support\Facades\Storage::url($avatar) : asset('vendor/adminlte/img/user2-160x160.jpg') }}"
                         class="rounded-circle mb-2" width="100" height="100" alt="{{ $user->name }}" style="object-fit: cover;">
                    <h3 class="mb-0">{{ $user->name }}</h3>
                    <p class="text-secondary">{{ $user->email }}</p>
                </div>

                <form action="{{ route('adminlte.profile.avatar.update') }}" method="post" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <label class="form-label">{{ __('adminlte.avatar') }}</label>
                    <input type="file" name="avatar" accept="image/*" class="form-control @error('avatar') is-invalid @enderror" required>
                    @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-upload me-1"></i> {{ __('adminlte.upload') }}
                    </button>
                </form>
            </x-adminlte-card>
        </div>

        <div class="col-lg-8">
            <x-adminlte-card bodyClass="p-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-profile" type="button">{{ __('adminlte.profile') }}</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-password" type="button">{{ __('adminlte.change_password') }}</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sessions" type="button">{{ __('adminlte.sessions') }}</button></li>
                    <li class="nav-item"><button class="nav-link text-danger" data-bs-toggle="tab" data-bs-target="#tab-danger" type="button">{{ __('adminlte.danger_zone') }}</button></li>
                </ul>

                <div class="tab-content p-3">
                    {{-- Profile --}}
                    <div class="tab-pane fade show active" id="tab-profile">
                        <form action="{{ route('adminlte.profile.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">{{ __('adminlte.name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('adminlte.email') }}</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <small class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>{{ __('adminlte.email_unverified') }}</small>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('adminlte.save') }}</button>
                        </form>
                    </div>

                    {{-- Password --}}
                    <div class="tab-pane fade" id="tab-password">
                        <form action="{{ route('adminlte.profile.password.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">{{ __('adminlte.current_password') }}</label>
                                <input type="password" name="current_password" autocomplete="current-password"
                                       class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('adminlte.new_password') }}</label>
                                <input type="password" name="password" autocomplete="new-password"
                                       class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('adminlte.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('adminlte.change_password') }}</button>
                        </form>
                    </div>

                    {{-- Sessions --}}
                    <div class="tab-pane fade" id="tab-sessions">
                        @if (count($sessions) > 0)
                            <ul class="list-group mb-3">
                                @foreach ($sessions as $session)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="bi bi-display me-2"></i>
                                            {{ $session->ip_address }}
                                            @if ($session->is_current_device)
                                                <span class="badge text-bg-success ms-2">{{ __('adminlte.this_device') }}</span>
                                            @endif
                                            <br><small class="text-secondary">{{ $session->last_active }}</small>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <form action="{{ route('adminlte.profile.sessions.logout-others') }}" method="post">
                                @csrf
                                @method('PUT')
                                <label class="form-label">{{ __('adminlte.confirm_password') }}</label>
                                <div class="input-group" style="max-width: 360px;">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    <button type="submit" class="btn btn-outline-danger">{{ __('adminlte.logout_other_sessions') }}</button>
                                </div>
                                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </form>
                        @else
                            <p class="text-secondary mb-0">{{ __('adminlte.sessions_db_only') }}</p>
                        @endif
                    </div>

                    {{-- Danger zone --}}
                    <div class="tab-pane fade" id="tab-danger">
                        <p class="text-secondary">{{ __('adminlte.delete_account_warning') }}</p>
                        <form action="{{ route('adminlte.profile.destroy') }}" method="post"
                              onsubmit="return confirm('{{ __('adminlte.delete_account_confirm') }}');">
                            @csrf
                            @method('DELETE')
                            <label class="form-label">{{ __('adminlte.confirm_password') }}</label>
                            <div class="input-group" style="max-width: 360px;">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                <button type="submit" class="btn btn-danger">{{ __('adminlte.delete_account') }}</button>
                            </div>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </form>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
