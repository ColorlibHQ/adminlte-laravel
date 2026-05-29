@extends('adminlte::master', ['title' => 'Dashboard'])

@php
    // This demo dashboard mirrors the AdminLTE 4 index.html. Enable the JS
    // libraries it needs so @pluginScripts injects them for this request.
    app(\ColorlibHQ\AdminLte\Plugins\PluginManager::class)->enable('apexcharts')->enable('jsvectormap');
    $img = fn ($f) => asset('vendor/adminlte/img/'.$f);
@endphp

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- ===== Small boxes ===== --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>150</h3>
                    <p>New Orders</p>
                </div>
                <i class="small-box-icon bi bi-bag"></i>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>53<sup class="fs-5">%</sup></h3>
                    <p>Bounce Rate</p>
                </div>
                <i class="small-box-icon bi bi-bar-chart"></i>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>User Registrations</p>
                </div>
                <i class="small-box-icon bi bi-person-add"></i>
                <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                </div>
                <i class="small-box-icon bi bi-pie-chart"></i>
                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- ===== Sales chart + World map ===== --}}
    <div class="row">
        <div class="col-lg-7 connectedSortable">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Sales Value</h3>
                </div>
                <div class="card-body">
                    <div id="revenue-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 connectedSortable">
            <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                <div class="card-header border-0">
                    <h3 class="card-title">Sales Value</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="world-map" style="height: 220px"></div>
                </div>
                <div class="card-footer border-0">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div id="sparkline-1" class="text-dark"></div>
                            <div class="text-white">Visitors</div>
                        </div>
                        <div class="col-4 text-center">
                            <div id="sparkline-2" class="text-dark"></div>
                            <div class="text-white">Online</div>
                        </div>
                        <div class="col-4 text-center">
                            <div id="sparkline-3" class="text-dark"></div>
                            <div class="text-white">Sales</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Direct Chat ===== --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card direct-chat direct-chat-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">Direct Chat</h3>
                    <div class="card-tools">
                        <span title="3 New Messages" class="badge text-bg-primary">3</span>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane">
                            <i class="bi bi-chat-text-fill"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-start">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-end">23 Jan 2:00 pm</span>
                            </div>
                            <img class="direct-chat-img" src="{{ $img('user1-128x128.jpg') }}" alt="message user image">
                            <div class="direct-chat-text">Is this template really for free? That's unbelievable!</div>
                        </div>
                        <div class="direct-chat-msg end">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-end">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-start">23 Jan 2:05 pm</span>
                            </div>
                            <img class="direct-chat-img" src="{{ $img('user3-128x128.jpg') }}" alt="message user image">
                            <div class="direct-chat-text">You better believe it!</div>
                        </div>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-start">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-end">23 Jan 5:37 pm</span>
                            </div>
                            <img class="direct-chat-img" src="{{ $img('user1-128x128.jpg') }}" alt="message user image">
                            <div class="direct-chat-text">Working with AdminLTE on a great new app! Wanna join?</div>
                        </div>
                        <div class="direct-chat-msg end">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-end">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-start">23 Jan 6:10 pm</span>
                            </div>
                            <img class="direct-chat-img" src="{{ $img('user3-128x128.jpg') }}" alt="message user image">
                            <div class="direct-chat-text">I would love to.</div>
                        </div>
                    </div>
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="{{ $img('user1-128x128.jpg') }}" alt="User Avatar">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date float-end">2/28/2023</small>
                                        </span>
                                        <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="{{ $img('user8-128x128.jpg') }}" alt="User Avatar">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Sarah Doe
                                            <small class="contacts-list-date float-end">2/23/2023</small>
                                        </span>
                                        <span class="contacts-list-msg">I will be waiting for...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="{{ $img('user3-128x128.jpg') }}" alt="User Avatar">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Nadia Jolie
                                            <small class="contacts-list-date float-end">2/20/2023</small>
                                        </span>
                                        <span class="contacts-list-msg">I'll call you back at...</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Latest members / to-do style filler to balance the row, matching the demo's right column feel --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                    <div class="card-tools">
                        <span class="badge text-bg-primary">8 New Members</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <img class="rounded-circle me-2" src="{{ $img('user1-128x128.jpg') }}" width="40" height="40" alt="">
                            <div class="flex-grow-1"><strong>Alexander Pierce</strong><div class="small text-muted">Joined the team</div></div>
                            <span class="text-muted small">2:00 pm</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <img class="rounded-circle me-2" src="{{ $img('user8-128x128.jpg') }}" width="40" height="40" alt="">
                            <div class="flex-grow-1"><strong>John Pierce</strong><div class="small text-muted">Sent a message</div></div>
                            <span class="text-muted small">3:30 pm</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <img class="rounded-circle me-2" src="{{ $img('user3-128x128.jpg') }}" width="40" height="40" alt="">
                            <div class="flex-grow-1"><strong>Nora Silvester</strong><div class="small text-muted">Updated a report</div></div>
                            <span class="text-muted small">5:37 pm</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ----- Sales area chart (verbatim from AdminLTE index.html) -----
            if (typeof ApexCharts !== 'undefined' && document.querySelector('#revenue-chart')) {
                new ApexCharts(document.querySelector('#revenue-chart'), {
                    series: [
                        { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
                        { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] },
                    ],
                    chart: { height: 300, type: 'area', toolbar: { show: false } },
                    legend: { show: false },
                    colors: ['#0d6efd', '#20c997'],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth' },
                    xaxis: {
                        type: 'datetime',
                        categories: ['2023-01-01', '2023-02-01', '2023-03-01', '2023-04-01', '2023-05-01', '2023-06-01', '2023-07-01'],
                    },
                    tooltip: { x: { format: 'MMMM yyyy' } },
                }).render();
            }

            // ----- World map -----
            if (typeof jsVectorMap !== 'undefined' && document.querySelector('#world-map')) {
                try { new jsVectorMap({ selector: '#world-map', map: 'world' }); } catch (e) { console.warn(e); }
            }

            // ----- Sparklines -----
            const spark = (sel, data) => {
                if (typeof ApexCharts === 'undefined' || !document.querySelector(sel)) return;
                new ApexCharts(document.querySelector(sel), {
                    series: [{ data }],
                    chart: { type: 'area', height: 50, sparkline: { enabled: true } },
                    stroke: { curve: 'straight' },
                    fill: { opacity: 0.3 },
                    yaxis: { min: 0 },
                    colors: ['#DCE6EC'],
                }).render();
            };
            spark('#sparkline-1', [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021]);
            spark('#sparkline-2', [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921]);
            spark('#sparkline-3', [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21]);
        });
    </script>
@endpush
