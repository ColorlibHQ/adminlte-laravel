@extends('adminlte::page')

@section('title', 'Small Box')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Small Box</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Widgets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Small Box</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Small Box (Stat card) --}}
    <h5 class="mb-2">Small Box</h5>

    {{-- Small boxes (Stat box) --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            {{-- small box --}}
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <i class="small-box-icon bi bi-cart" aria-hidden="true"></i>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        {{-- ./col --}}
        <div class="col-lg-3 col-6">
            {{-- small box --}}
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>53<sup class="fs-5">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <i class="small-box-icon bi bi-bar-chart" aria-hidden="true"></i>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        {{-- ./col --}}
        <div class="col-lg-3 col-6">
            {{-- small box --}}
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <i class="small-box-icon bi bi-person-add" aria-hidden="true"></i>
                <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        {{-- ./col --}}
        <div class="col-lg-3 col-6">
            {{-- small box --}}
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <i class="small-box-icon bi bi-pie-chart" aria-hidden="true"></i>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        {{-- ./col --}}
    </div>
    {{-- /.row --}}
@stop
