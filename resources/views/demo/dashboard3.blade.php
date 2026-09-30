@extends('adminlte::page')

@php
    // This demo page uses Chart.js. Enable the plugin so its assets are injected.
    app(\ColorlibHQ\AdminLte\Plugins\PluginManager::class)->enable('chartjs');
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
                        <div id="visitors-chart" style="height: 200px"></div>
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
                        <div id="sales-chart" style="height: 200px"></div>
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
            const charts = window.AdminLteCharts;
            if (!charts) {
                return;
            }

            // Shades every other band between the y-axis gridlines.
            const zebra = {
                id: 'zebra',
                beforeDatasetsDraw(chart) {
                    const { ctx, chartArea: area, scales: { y } } = chart;
                    ctx.save();
                    ctx.fillStyle = charts.color('var(--bs-tertiary-bg)');
                    y.ticks.forEach((tick, i) => {
                        if (i % 2 || i === y.ticks.length - 1) {
                            return;
                        }
                        const bottom = y.getPixelForTick(i);
                        const top = y.getPixelForTick(i + 1);
                        ctx.fillRect(area.left, top, area.right - area.left, bottom - top);
                    });
                    ctx.restore();
                },
            };

            // - VISITORS CHART -
            charts.create('#visitors-chart', {
                type: 'line',
                data: {
                    labels: ['22th', '23th', '24th', '25th', '26th', '27th', '28th'],
                    datasets: [
                        { label: 'High - 2023', data: [100, 120, 170, 167, 180, 177, 160], borderColor: 'var(--bs-primary)', pointRadius: 2 },
                        { label: 'Low - 2023', data: [60, 80, 70, 67, 80, 77, 100], borderColor: 'var(--bs-gray-500)', pointRadius: 2 },
                    ],
                },
                options: {
                    plugins: { legend: { display: false } },
                },
                plugins: [zebra],
            });

            // - SALES CHART -
            charts.create('#sales-chart', {
                type: 'bar',
                data: {
                    labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    datasets: [
                        { label: 'Net Profit', data: [44, 55, 57, 56, 61, 58, 63, 60, 66], backgroundColor: 'var(--bs-primary)' },
                        { label: 'Revenue', data: [76, 85, 101, 98, 87, 105, 91, 114, 94], backgroundColor: 'var(--bs-teal)' },
                        { label: 'Free Cash Flow', data: [35, 41, 36, 26, 45, 48, 52, 53, 41], backgroundColor: 'var(--bs-warning)' },
                    ],
                },
                options: {
                    categoryPercentage: 0.55,
                    barPercentage: 0.85,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (item) => `${item.dataset.label}: $ ${item.raw} thousands` } },
                    },
                },
            });
        });
    </script>
@endpush
