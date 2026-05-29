@extends('adminlte::page')

@section('title', __('adminlte.invoice'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.invoice') }} <small class="text-muted">{{ $invoice['number'] }}</small></h1>
@stop

@section('content')
    @php($total = collect($invoice['items'])->sum(fn ($i) => $i['qty'] * $i['price']))

    <x-adminlte-card>
        <div class="row mb-4">
            <div class="col-6">
                <h4>{{ __('adminlte.from') }}</h4>
                <address class="text-muted">{{ $invoice['from'] }}</address>
            </div>
            <div class="col-6 text-end">
                <h4>{{ __('adminlte.to') }}</h4>
                <address class="text-muted">{{ $invoice['to'] }}</address>
                <div class="small">{{ __('adminlte.date') }}: {{ $invoice['date'] }}</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('adminlte.description') }}</th>
                        <th class="text-end">{{ __('adminlte.qty') }}</th>
                        <th class="text-end">{{ __('adminlte.price') }}</th>
                        <th class="text-end">{{ __('adminlte.subtotal') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice['items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-end">{{ $item['qty'] }}</td>
                            <td class="text-end">${{ number_format($item['price'], 2) }}</td>
                            <td class="text-end">${{ number_format($item['qty'] * $item['price'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">{{ __('adminlte.total') }}</th>
                        <th class="text-end">${{ number_format($total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <x-slot name="footer">
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="bi bi-printer me-1"></i> {{ __('adminlte.print') }}
            </button>
        </x-slot>
    </x-adminlte-card>
@stop
