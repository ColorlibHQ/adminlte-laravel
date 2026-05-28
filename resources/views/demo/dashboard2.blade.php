@extends('adminlte::page')

@section('title', 'Dashboard v2')

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h1>Dashboard v2</h1></div>
    </div>
@stop

@section('content')
    <div class="row g-3">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="150" text="New Orders" icon="bi bi-cart" theme="primary" url="#" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="44" text="Registrations" icon="bi bi-person-plus" theme="success" url="#" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="$4,210" text="Revenue" icon="bi bi-currency-dollar" theme="warning" url="#" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="92%" text="Completion" icon="bi bi-percent" theme="info" url="#" />
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-8">
            <x-adminlte-card title="Sales Statistics" icon="bi bi-bar-chart" theme="primary" outline collapsible>
                <x-adminlte-chart
                    type="area"
                    :series="[
                        ['name' => 'Sales', 'data' => [10, 20, 15, 25, 30, 28]],
                    ]"
                    :categories="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']"
                    height="300px"
                />
            </x-adminlte-card>
        </div>
        <div class="col-md-4">
            <x-adminlte-card title="Top Products" icon="bi bi-box" theme="success" outline>
                <ul class="list-group">
                    @for ($i = 1; $i <= 3; $i++)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Product {{ $i }}</span>
                            <span class="badge bg-primary">{{ $i * 10 }}</span>
                        </li>
                    @endfor
                </ul>
            </x-adminlte-card>
        </div>
    </div>
@stop
