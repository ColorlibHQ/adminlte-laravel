@extends('adminlte::page')

@section('title', 'Info Box')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Info Box</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Widgets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Info Box</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <h5 class="mb-2">Info Box</h5>
    {{-- begin::Row --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                    <i class="bi bi-gear-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">
                        10
                        <small>%</small>
                    </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                    <i class="bi bi-cart-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Sales</span>
                    <span class="info-box-number">760</span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-warning shadow-sm">
                    <i class="bi bi-people-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">New Members</span>
                    <span class="info-box-number">2,000</span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-danger shadow-sm">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}

    {{-- =========================================================== --}}
    <h5 class="mb-2">
        Info Box With Custom Shadows
        <small>
            <i>Using Bootstrap's Shadow Utility</i>
        </small>
    </h5>
    {{-- begin::Row --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-none">
                <span class="info-box-icon text-bg-primary shadow-sm">
                    <i class="bi bi-gear-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">
                        10
                        <small>%</small>
                    </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon text-bg-success shadow-sm">
                    <i class="bi bi-cart-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Sales</span>
                    <span class="info-box-number">760</span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow">
                <span class="info-box-icon text-bg-warning shadow-sm">
                    <i class="bi bi-people-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">New Members</span>
                    <span class="info-box-number">2,000</span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-lg">
                <span class="info-box-icon text-bg-danger shadow-sm">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}

    {{-- =========================================================== --}}
    <h5 class="mt-4 mb-2">Info Box With <code>bg-*</code></h5>
    {{-- begin::Row --}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-primary">
                <span class="info-box-icon">
                    <i class="bi bi-bookmark-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Bookmarks</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-success">
                <span class="info-box-icon">
                    <i class="bi bi-hand-thumbs-up"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-warning">
                <span class="info-box-icon">
                    <i class="bi bi-calendar3"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Events</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-danger">
                <span class="info-box-icon">
                    <i class="bi bi-chat-text-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Comments</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}

    {{-- =========================================================== --}}
    <h5 class="mt-4 mb-2">Info Box With <code>bg-gradient</code></h5>
    {{-- begin::Row --}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-primary bg-gradient">
                <span class="info-box-icon">
                    <i class="bi bi-bookmark-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Bookmarks</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-success bg-gradient">
                <span class="info-box-icon">
                    <i class="bi bi-hand-thumbs-up"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-warning bg-gradient">
                <span class="info-box-icon">
                    <i class="bi bi-calendar3"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Events</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box text-bg-danger bg-gradient">
                <span class="info-box-icon">
                    <i class="bi bi-chat-text-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Comments</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description"> 70% Increase in 30 Days </span>
                </div>
                {{-- /.info-box-content --}}
            </div>
            {{-- /.info-box --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- end::Row --}}
@stop
