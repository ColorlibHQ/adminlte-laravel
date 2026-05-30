@extends('adminlte::page')

@section('title', __('adminlte.activity_log'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.activity_log') }}</h1>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-clock-history" title="{{ __('adminlte.activity_log') }}" bodyClass="p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>{{ __('adminlte.user') }}</th>
                        <th>{{ __('adminlte.event') }}</th>
                        <th>{{ __('adminlte.description') }}</th>
                        <th>{{ __('adminlte.ip_address') }}</th>
                        <th>{{ __('adminlte.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr>
                            <td>{{ $activity->user?->name ?? __('adminlte.system') }}</td>
                            <td><span class="badge text-bg-secondary">{{ $activity->event }}</span></td>
                            <td>{{ $activity->description }}</td>
                            <td class="text-secondary">{{ $activity->ip_address }}</td>
                            <td class="text-secondary">{{ $activity->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-secondary py-4">{{ __('adminlte.no_activity') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($activities->hasPages())
            <x-slot name="footer">{{ $activities->links() }}</x-slot>
        @endif
    </x-adminlte-card>
@stop
