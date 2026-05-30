@extends('adminlte::page')

@section('title', __('adminlte.dashboard'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.dashboard') }}</h1>
@stop

@section('content')
    {{-- Real, data-driven stat boxes --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['users'] }}" text="{{ __('adminlte.users') }}"
                theme="primary" icon="bi bi-people"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.users.index') ? route('adminlte.users.index') : null" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['projects'] }}" text="{{ __('adminlte.projects') }}"
                theme="success" icon="bi bi-kanban"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.projects.index') ? route('adminlte.projects.index') : null" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['unread_messages'] }}" text="{{ __('adminlte.messages') }}"
                theme="warning" icon="bi bi-envelope"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.mailbox.index') ? route('adminlte.mailbox.index') : null" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['events'] }}" text="{{ __('adminlte.events') }}"
                theme="info" icon="bi bi-calendar-event"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.calendar.index') ? route('adminlte.calendar.index') : null" />
        </div>
    </div>

    <div class="row">
        {{-- Projects by status --}}
        <div class="col-md-6">
            <x-adminlte-card icon="bi bi-bar-chart" title="{{ __('adminlte.projects') }}">
                @forelse ($projectsByStatus as $status => $total)
                    @php($pct = $stats['projects'] > 0 ? round($total / $stats['projects'] * 100) : 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('adminlte.status_'.$status) }}</span>
                            <span class="text-secondary">{{ $total }}</span>
                        </div>
                        <div class="progress" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar text-bg-primary" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary mb-0">{{ __('adminlte.no_projects') }}</p>
                @endforelse
            </x-adminlte-card>
        </div>

        {{-- Recent activity --}}
        <div class="col-md-6">
            <x-adminlte-card icon="bi bi-clock-history" title="{{ __('adminlte.activity') }}" bodyClass="p-0">
                <div class="list-group list-group-flush">
                    @forelse ($recentActivity as $entry)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span><span class="badge text-bg-secondary me-2">{{ $entry->event }}</span>{{ $entry->description }}</span>
                                <small class="text-secondary">{{ \Illuminate\Support\Carbon::parse($entry->created_at)->diffForHumans() }}</small>
                            </div>
                            <small class="text-secondary">{{ $entry->user_name ?? __('adminlte.system') }}</small>
                        </div>
                    @empty
                        <div class="list-group-item text-secondary">{{ __('adminlte.no_recent_activity') }}</div>
                    @endforelse
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
