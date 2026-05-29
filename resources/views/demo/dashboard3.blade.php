@extends('adminlte::page')

@php
    // This demo page uses ApexCharts. Enable the plugin so its assets are injected.
    app(\ColorlibHQ\AdminLte\Plugins\PluginManager::class)->enable('apexcharts');
@endphp

@section('title', 'Dashboard v3')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard v3</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard v3</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            {{-- Online Store Visitors --}}
            <div class="card mb-4">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Online Store Visitors</h3>
                        <a href="javascript:void(0);" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="fw-bold fs-5">820</span>
                            <span>Visitors Over Time</span>
                        </p>
                        <p class="ms-auto d-flex flex-column text-end">
                            <span class="text-success"> <i class="bi bi-arrow-up"></i> 12.5% </span>
                            <span class="text-secondary">Since last week</span>
                        </p>
                    </div>
                    {{-- /.d-flex --}}
                    <div class="position-relative mb-4">
                        <div id="visitors-chart"></div>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <span class="me-2">
                            <i class="bi bi-square-fill text-primary"></i> This Week
                        </span>
                        <span> <i class="bi bi-square-fill text-secondary"></i> Last Week </span>
                    </div>
                </div>
            </div>
            {{-- /.card --}}

            {{-- Products --}}
            <div class="card mb-4">
                <div class="card-header border-0">
                    <h3 class="card-title">Products</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="bi bi-download"></i>
                        </a>
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="bi bi-list"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Sales</th>
                                <th>More</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="https://placehold.co/32x32" alt="Product 1" class="rounded-circle img-size-32 me-2" />
                                    Some Product
                                </td>
                                <td>$13 USD</td>
                                <td>
                                    <small class="text-success me-1">
                                        <i class="bi bi-arrow-up"></i>
                                        12%
                                    </small>
                                    12,000 Sold
                                </td>
                                <td>
                                    <a href="#" class="text-secondary">
                                        <i class="bi bi-search"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://placehold.co/32x32" alt="Product 1" class="rounded-circle img-size-32 me-2" />
                                    Another Product
                                </td>
                                <td>$29 USD</td>
                                <td>
                                    <small class="text-info me-1">
                                        <i class="bi bi-arrow-down"></i>
                                        0.5%
                                    </small>
                                    123,234 Sold
                                </td>
                                <td>
                                    <a href="#" class="text-secondary">
                                        <i class="bi bi-search"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://placehold.co/32x32" alt="Product 1" class="rounded-circle img-size-32 me-2" />
                                    Amazing Product
                                </td>
                                <td>$1,230 USD</td>
                                <td>
                                    <small class="text-danger me-1">
                                        <i class="bi bi-arrow-down"></i>
                                        3%
                                    </small>
                                    198 Sold
                                </td>
                                <td>
                                    <a href="#" class="text-secondary">
                                        <i class="bi bi-search"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="https://placehold.co/32x32" alt="Product 1" class="rounded-circle img-size-32 me-2" />
                                    Perfect Item
                                    <span class="badge text-bg-danger">NEW</span>
                                </td>
                                <td>$199 USD</td>
                                <td>
                                    <small class="text-success me-1">
                                        <i class="bi bi-arrow-up"></i>
                                        63%
                                    </small>
                                    87 Sold
                                </td>
                                <td>
                                    <a href="#" class="text-secondary">
                                        <i class="bi bi-search"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col-lg-6 --}}

        <div class="col-lg-6">
            {{-- Sales --}}
            <div class="card mb-4">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Sales</h3>
                        <a href="javascript:void(0);" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="fw-bold fs-5">$18,230.00</span>
                            <span>Sales Over Time</span>
                        </p>
                        <p class="ms-auto d-flex flex-column text-end">
                            <span class="text-success"> <i class="bi bi-arrow-up"></i> 33.1% </span>
                            <span class="text-secondary">Since Past Year</span>
                        </p>
                    </div>
                    {{-- /.d-flex --}}
                    <div class="position-relative mb-4">
                        <div id="sales-chart"></div>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <span class="me-2">
                            <i class="bi bi-square-fill text-primary"></i> This year
                        </span>
                        <span> <i class="bi bi-square-fill text-secondary"></i> Last year </span>
                    </div>
                </div>
            </div>
            {{-- /.card --}}

            {{-- Online Store Overview --}}
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Online Store Overview</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-tool">
                            <i class="bi bi-download"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-tool">
                            <i class="bi bi-list"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                        <p class="text-success fs-2">
                            <i class="bi bi-arrow-repeat" style="font-size: 32px;" aria-hidden="true"></i>
                        </p>
                        <p class="d-flex flex-column text-end">
                            <span class="fw-bold">
                                <i class="bi bi-graph-up-arrow text-success"></i> 12%
                            </span>
                            <span class="text-secondary">CONVERSION RATE</span>
                        </p>
                    </div>
                    {{-- /.d-flex --}}
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                        <p class="text-info fs-2">
                            <i class="bi bi-cart3" style="font-size: 32px;" aria-hidden="true"></i>
                        </p>
                        <p class="d-flex flex-column text-end">
                            <span class="fw-bold">
                                <i class="bi bi-graph-up-arrow text-info"></i> 0.8%
                            </span>
                            <span class="text-secondary">SALES RATE</span>
                        </p>
                    </div>
                    {{-- /.d-flex --}}
                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <p class="text-danger fs-2">
                            <i class="bi bi-people" style="font-size: 32px;" aria-hidden="true"></i>
                        </p>
                        <p class="d-flex flex-column text-end">
                            <span class="fw-bold">
                                <i class="bi bi-graph-down-arrow text-danger"></i>
                                1%
                            </span>
                            <span class="text-secondary">REGISTRATION RATE</span>
                        </p>
                    </div>
                    {{-- /.d-flex --}}
                </div>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col-lg-6 --}}
    </div>
    {{-- /.row --}}
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof ApexCharts === 'undefined') {
                return;
            }

            // - VISITORS CHART -
            const visitors_chart_options = {
                series: [
                    { name: 'High - 2023', data: [100, 120, 170, 167, 180, 177, 160] },
                    { name: 'Low - 2023', data: [60, 80, 70, 67, 80, 77, 100] },
                ],
                chart: {
                    height: 200,
                    type: 'line',
                    toolbar: { show: false },
                },
                colors: ['#0d6efd', '#adb5bd'],
                stroke: { curve: 'smooth' },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5,
                    },
                },
                legend: { show: false },
                markers: { size: 1 },
                xaxis: {
                    categories: ['22th', '23th', '24th', '25th', '26th', '27th', '28th'],
                },
            };
            const visitors_chart_el = document.querySelector('#visitors-chart');
            if (visitors_chart_el) {
                new ApexCharts(visitors_chart_el, visitors_chart_options).render();
            }

            // - SALES CHART -
            const sales_chart_options = {
                series: [
                    { name: 'Net Profit', data: [44, 55, 57, 56, 61, 58, 63, 60, 66] },
                    { name: 'Revenue', data: [76, 85, 101, 98, 87, 105, 91, 114, 94] },
                    { name: 'Free Cash Flow', data: [35, 41, 36, 26, 45, 48, 52, 53, 41] },
                ],
                chart: {
                    type: 'bar',
                    height: 200,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                    },
                },
                legend: { show: false },
                colors: ['#0d6efd', '#20c997', '#ffc107'],
                dataLabels: { enabled: false },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent'],
                },
                xaxis: {
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return '$ ' + val + ' thousands';
                        },
                    },
                },
            };
            const sales_chart_el = document.querySelector('#sales-chart');
            if (sales_chart_el) {
                new ApexCharts(sales_chart_el, sales_chart_options).render();
            }
        });
    </script>
@endpush
