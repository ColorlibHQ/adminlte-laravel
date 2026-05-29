@extends('adminlte::page')

@section('title', __('adminlte.settings'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.settings') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.settings') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row g-3">
        {{-- Left rail --}}
        <div class="col-md-3">
            <div class="list-group list-group-flush nav nav-pills flex-column" id="settings-nav" role="tablist">
                <a href="#account" class="list-group-item list-group-item-action active"
                    data-bs-toggle="pill" role="tab" aria-selected="true">
                    <i class="bi bi-person me-2" aria-hidden="true"></i>Account
                </a>
                <a href="#notifications" class="list-group-item list-group-item-action"
                    data-bs-toggle="pill" role="tab">
                    <i class="bi bi-bell me-2" aria-hidden="true"></i>{{ __('adminlte.notifications') }}
                </a>
                <a href="#security" class="list-group-item list-group-item-action"
                    data-bs-toggle="pill" role="tab">
                    <i class="bi bi-shield-lock me-2" aria-hidden="true"></i>Security
                </a>
                <a href="#billing" class="list-group-item list-group-item-action"
                    data-bs-toggle="pill" role="tab">
                    <i class="bi bi-credit-card me-2" aria-hidden="true"></i>Billing
                </a>
                <a href="#danger" class="list-group-item list-group-item-action text-danger"
                    data-bs-toggle="pill" role="tab">
                    <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>Danger zone
                </a>
            </div>
        </div>

        {{-- Tab content --}}
        <div class="col-md-9">
            <div class="tab-content">
                {{-- Account (the only section with a real, submitted form) --}}
                <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="bi bi-gear me-1" aria-hidden="true"></i> {{ __('adminlte.general_settings') }}
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('adminlte.settings.update') }}" class="row g-3">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <label class="form-label" for="settings-name">{{ __('adminlte.name') }}</label>
                                    <input type="text" name="name" id="settings-name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="settings-email">{{ __('adminlte.email') }}</label>
                                    <input type="email" id="settings-email" class="form-control"
                                        value="{{ $user->email }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="settings-locale">{{ __('adminlte.language') }}</label>
                                    <select name="locale" id="settings-locale"
                                        class="form-select @error('locale') is-invalid @enderror">
                                        @foreach (['en' => 'English', 'de' => 'Deutsch', 'es' => 'Español', 'fr' => 'Français'] as $code => $label)
                                            <option value="{{ $code }}" @selected(old('locale', session('locale', app()->getLocale())) === $code)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('locale')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="settings-tz">Time zone</label>
                                    <select class="form-select" id="settings-tz" disabled>
                                        <option>UTC</option>
                                        <option selected>America/Los_Angeles</option>
                                        <option>Europe/London</option>
                                        <option>Asia/Tokyo</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-1" aria-hidden="true"></i> {{ __('adminlte.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Notifications (display-only toggles) --}}
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ __('adminlte.notifications') }}</div>
                        </div>
                        <div class="card-body">
                            <p class="text-secondary">Choose what to be notified about.</p>

                            @foreach ([
                                ['Product updates', 'Major releases and changelogs', true],
                                ['Security alerts', 'Sign-in attempts and account changes', true],
                                ['Weekly digest', 'A summary of activity in your workspace', false],
                                ['Mentions', 'When a teammate @@mentions you', false],
                            ] as $i => $notif)
                                <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $notif[0] }}</p>
                                        <small class="text-secondary">{{ $notif[1] }}</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="notif-{{ $i }}" @checked($notif[2])>
                                        <label class="visually-hidden" for="notif-{{ $i }}">Toggle {{ $notif[0] }}</label>
                                    </div>
                                </div>
                            @endforeach

                            <button type="button" class="btn btn-primary mt-3" disabled>Save preferences</button>
                        </div>
                    </div>
                </div>

                {{-- Security (display-only) --}}
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Password</div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="pwd-current">Current password</label>
                                    <input type="password" class="form-control" id="pwd-current" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="pwd-new">New password</label>
                                    <input type="password" class="form-control" id="pwd-new" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="pwd-confirm">Confirm new password</label>
                                    <input type="password" class="form-control" id="pwd-confirm" disabled>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary" disabled>Update password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="card-title">Two-factor authentication</div>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 fw-semibold">Authenticator app</p>
                                <small class="text-secondary">Use an authenticator app such as 1Password or Authy.</small>
                            </div>
                            <button type="button" class="btn btn-outline-primary" disabled>Enable</button>
                        </div>
                    </div>
                </div>

                {{-- Billing (display-only) --}}
                <div class="tab-pane fade" id="billing" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Current plan</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <p class="mb-0 fw-semibold">Pro plan</p>
                                    <small class="text-secondary">$29 / month &middot; Renews June 18, 2026</small>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Change plan</a>
                            </div>
                            <hr>
                            <p class="fw-semibold mb-2">Payment method</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-credit-card-2-front me-2" aria-hidden="true"></i> Visa ending in 4242
                                </div>
                                <a href="#" class="btn btn-link btn-sm">Update</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Danger zone (display-only) --}}
                <div class="tab-pane fade" id="danger" role="tabpanel">
                    <div class="card border-danger">
                        <div class="card-header bg-danger-subtle">
                            <div class="card-title text-danger">Danger zone</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="mb-0 fw-semibold">Export account data</p>
                                    <small class="text-secondary">Download a copy of all your data as a ZIP archive.</small>
                                </div>
                                <button type="button" class="btn btn-outline-secondary" disabled>Export</button>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-0 fw-semibold text-danger">Delete account</p>
                                    <small class="text-secondary">
                                        This will permanently delete your account and all associated data. This cannot be undone.
                                    </small>
                                </div>
                                <button type="button" class="btn btn-danger" disabled>Delete account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
