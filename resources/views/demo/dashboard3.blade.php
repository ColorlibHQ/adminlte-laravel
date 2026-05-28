@extends('adminlte::page')

@section('title', 'Dashboard v3')

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h1>Dashboard v3</h1></div>
    </div>
@stop

@section('content')
    <div class="row g-3">
        <div class="col-md-6">
            <x-adminlte-card title="Traffic Sources" icon="bi bi-diagram-3" theme="primary" outline>
                <x-adminlte-chart
                    type="donut"
                    :series="[25, 35, 40]"
                    :categories="['Direct', 'Organic', 'Referral']"
                    height="300px"
                />
            </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Server Status" icon="bi bi-server" theme="success" outline>
                <div class="progress mb-3">
                    <div class="progress-bar" style="width: 85%">CPU: 85%</div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-warning" style="width: 65%">Memory: 65%</div>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-danger" style="width: 45%">Disk: 45%</div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-12">
            <x-adminlte-card title="Monthly Performance" icon="bi bi-line-chart" theme="info" outline>
                <x-adminlte-chart
                    type="line"
                    :series="[
                        ['name' => 'Revenue', 'data' => [5, 10, 8, 15, 20, 18, 22]],
                        ['name' => 'Users', 'data' => [3, 8, 6, 12, 18, 16, 20]],
                    ]"
                    :categories="['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']"
                    height="300px"
                />
            </x-adminlte-card>
        </div>
    </div>
@stop
