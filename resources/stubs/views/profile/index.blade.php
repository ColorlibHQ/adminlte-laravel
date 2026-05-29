@extends('adminlte::page')

@section('title', __('adminlte.profile'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.profile') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.profile') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row g-3">
        {{-- Profile sidebar --}}
        <div class="col-md-3">
            {{-- About card --}}
            <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid rounded-circle mb-2"
                        src="{{ asset('vendor/adminlte/img/user2-160x160.jpg') }}"
                        alt="{{ $user->name }}">

                    <h3 class="profile-username">{{ $user->name }}</h3>
                    <p class="text-secondary mb-3">Product Designer</p>

                    <ul class="list-group list-group-unbordered mb-3 text-start">
                        <li class="list-group-item d-flex justify-content-between">
                            <b>{{ __('adminlte.followers') }}</b>
                            <span class="float-end">1,322</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>Following</b>
                            <span class="float-end">543</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>{{ __('adminlte.friends') }}</b>
                            <span class="float-end">13,287</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>{{ __('adminlte.member_since') }}</b>
                            <span class="float-end">{{ $user->created_at?->format('M Y') }}</span>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus me-1" aria-hidden="true"></i>
                        Follow
                    </a>
                </div>
            </div>

            {{-- About Me card --}}
            <div class="card card-primary card-outline mt-3">
                <div class="card-header">
                    <div class="card-title">About Me</div>
                </div>
                <div class="card-body">
                    <strong><i class="bi bi-mortarboard me-1" aria-hidden="true"></i> Education</strong>
                    <p class="text-secondary">BS in Computer Science from the University of Tennessee at Knoxville</p>
                    <hr>

                    <strong><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Location</strong>
                    <p class="text-secondary">Malibu, California</p>
                    <hr>

                    <strong><i class="bi bi-tags me-1" aria-hidden="true"></i> Skills</strong>
                    <p>
                        <span class="badge text-bg-secondary me-1">UI/UX</span>
                        <span class="badge text-bg-secondary me-1">Figma</span>
                        <span class="badge text-bg-secondary me-1">Design Systems</span>
                        <span class="badge text-bg-secondary">Research</span>
                    </p>
                    <hr>

                    <strong><i class="bi bi-pencil-square me-1" aria-hidden="true"></i> Notes</strong>
                    <p class="text-secondary mb-0">
                        Lorem ipsum represents a long-held tradition for designers, typographers and the like.
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabbed content --}}
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-pills p-2" id="profile-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="activity-tab" data-bs-toggle="pill"
                                data-bs-target="#activity" type="button" role="tab"
                                aria-controls="activity" aria-selected="true">
                                {{ __('adminlte.activity') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="timeline-tab" data-bs-toggle="pill"
                                data-bs-target="#timeline" type="button" role="tab"
                                aria-controls="timeline" aria-selected="false">
                                Timeline
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="pill"
                                data-bs-target="#settings" type="button" role="tab"
                                aria-controls="settings" aria-selected="false">
                                {{ __('adminlte.settings') }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        {{-- Activity tab --}}
                        <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <article class="d-flex gap-3 mb-4">
                                <img class="flex-shrink-0 rounded-circle"
                                    src="{{ asset('vendor/adminlte/img/user2-160x160.jpg') }}"
                                    alt="{{ $user->name }}" style="width: 40px; height: 40px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="h6 mb-0">{{ $user->name }}</h4>
                                        <small class="text-secondary">2 hours ago</small>
                                    </div>
                                    <p class="mb-2">
                                        Shipped <a href="#">design-system v2.4</a> with a refreshed color palette
                                        and new motion primitives.
                                    </p>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-hand-thumbs-up me-1" aria-hidden="true"></i> Like
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary ms-1">
                                        <i class="bi bi-chat me-1" aria-hidden="true"></i> Comment
                                    </a>
                                </div>
                            </article>

                            <article class="d-flex gap-3 mb-4">
                                <img class="flex-shrink-0 rounded-circle"
                                    src="{{ asset('vendor/adminlte/img/user1-128x128.jpg') }}"
                                    alt="Sarah Ross" style="width: 40px; height: 40px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="h6 mb-0">Sarah Ross</h4>
                                        <small class="text-secondary">Yesterday</small>
                                    </div>
                                    <p class="mb-0">
                                        Posted a question in <a href="#">#design-help</a>: how should we handle
                                        focus rings on dark-themed CTA buttons?
                                    </p>
                                </div>
                            </article>

                            <article class="d-flex gap-3">
                                <img class="flex-shrink-0 rounded-circle"
                                    src="{{ asset('vendor/adminlte/img/user8-128x128.jpg') }}"
                                    alt="Mike Doe" style="width: 40px; height: 40px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="h6 mb-0">Mike Doe</h4>
                                        <small class="text-secondary">3 days ago</small>
                                    </div>
                                    <p class="mb-0">Updated the project board and added <em>Research</em> to the roadmap.</p>
                                </div>
                            </article>
                        </div>

                        {{-- Timeline tab --}}
                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <span class="timeline-icon bg-success">
                                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                                    </span>
                                    <div class="timeline-body">
                                        <span class="time"><i class="bi bi-clock me-1"></i> May 16, 2026</span>
                                        <h3 class="timeline-header">Released v2.4 of the design system</h3>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <span class="timeline-icon bg-info">
                                        <i class="bi bi-mic" aria-hidden="true"></i>
                                    </span>
                                    <div class="timeline-body">
                                        <span class="time"><i class="bi bi-clock me-1"></i> April 22, 2026</span>
                                        <h3 class="timeline-header">Spoke at the local UX meetup</h3>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <span class="timeline-icon bg-warning">
                                        <i class="bi bi-briefcase" aria-hidden="true"></i>
                                    </span>
                                    <div class="timeline-body">
                                        <span class="time"><i class="bi bi-clock me-1"></i> March 1, 2026</span>
                                        <h3 class="timeline-header">Joined the product team as Senior Designer</h3>
                                    </div>
                                </div>

                                <div class="timeline-end">
                                    <i class="bi bi-clock"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Settings tab --}}
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="POST" action="{{ route('adminlte.profile.update') }}" class="row g-3">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <label class="form-label" for="profile-name">{{ __('adminlte.name') }}</label>
                                    <input type="text" name="name" id="profile-name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="profile-email">{{ __('adminlte.email') }}</label>
                                    <input type="email" name="email" id="profile-email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            </div>
        </div>
    </div>
@stop
