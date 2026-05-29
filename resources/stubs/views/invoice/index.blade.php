@extends('adminlte::page')

@section('title', __('adminlte.invoice'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">{{ __('adminlte.invoice') }}</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('adminlte.pages') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.invoice') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @php
        $subtotal = collect($invoice['items'])->sum(fn ($i) => $i['qty'] * $i['price']);
        $tax = $subtotal * 0.093;
        $total = $subtotal + $tax;
    @endphp

    {{-- Action bar (hidden on print) --}}
    <div class="d-flex justify-content-end gap-2 mb-3 d-print-none">
        <button class="btn btn-outline-secondary" onclick="window.print()" type="button">
            <i class="bi bi-printer me-1" aria-hidden="true"></i>{{ __('adminlte.print') }}
        </button>
        <a href="#" class="btn btn-outline-secondary">
            <i class="bi bi-download me-1" aria-hidden="true"></i>{{ __('adminlte.generate_pdf') }}
        </a>
        <a href="#" class="btn btn-primary">
            <i class="bi bi-credit-card me-1" aria-hidden="true"></i>{{ __('adminlte.submit_payment') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4 p-md-5">
            {{-- Header --}}
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h2 class="h4 mb-0 text-primary fw-semibold">
                        <i class="bi bi-globe me-1" aria-hidden="true"></i>{{ config('adminlte.title', 'AdminLTE') }}
                    </h2>
                    <p class="text-secondary mb-0 small mt-2">{!! nl2br(e($invoice['from'])) !!}</p>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <h1 class="h2 mb-1">{{ __('adminlte.invoice') }}</h1>
                    <p class="text-secondary mb-0">
                        <span class="fw-semibold">#</span>{{ $invoice['number'] }}
                    </p>
                    <p class="text-secondary mb-0 small">{{ __('adminlte.date') }}: {{ $invoice['date'] }}</p>
                </div>
            </div>

            {{-- Billing details --}}
            <div class="row mb-4">
                <div class="col-sm-6">
                    <p class="text-secondary small mb-1">{{ __('adminlte.from') }}</p>
                    <address class="mb-0">{!! nl2br(e($invoice['from'])) !!}</address>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <p class="text-secondary small mb-1">{{ __('adminlte.to') }}</p>
                    <address class="mb-0">{!! nl2br(e($invoice['to'])) !!}</address>
                </div>
            </div>

            {{-- Items --}}
            <div class="table-responsive mb-3">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="border-top-0 text-end" style="width: 6rem">{{ __('adminlte.qty') }}</th>
                            <th class="border-top-0">{{ __('adminlte.description') }}</th>
                            <th class="border-top-0 text-end" style="width: 9rem">{{ __('adminlte.price') }}</th>
                            <th class="border-top-0 text-end" style="width: 9rem">{{ __('adminlte.subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice['items'] as $item)
                            <tr>
                                <td class="text-end">{{ $item['qty'] }}</td>
                                <td>
                                    <p class="mb-0 fw-semibold">{{ $item['name'] }}</p>
                                </td>
                                <td class="text-end">${{ number_format($item['price'], 2) }}</td>
                                <td class="text-end">${{ number_format($item['qty'] * $item['price'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="row justify-content-end">
                <div class="col-md-5 col-lg-4">
                    <dl class="row mb-0">
                        <dt class="col-7 text-secondary fw-normal">{{ __('adminlte.subtotal') }}</dt>
                        <dd class="col-5 text-end mb-2">${{ number_format($subtotal, 2) }}</dd>
                        <dt class="col-7 text-secondary fw-normal">{{ __('adminlte.tax') }} (9.3%)</dt>
                        <dd class="col-5 text-end mb-2">${{ number_format($tax, 2) }}</dd>
                        <dt class="col-7 fw-semibold border-top pt-2">{{ __('adminlte.total') }}</dt>
                        <dd class="col-5 text-end fw-semibold border-top pt-2 mb-0">${{ number_format($total, 2) }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Footer note --}}
            <hr class="my-4">
            <p class="text-secondary small mb-0">
                {{ __('adminlte.invoice_footer_note') }}
            </p>
        </div>
    </div>
@stop
