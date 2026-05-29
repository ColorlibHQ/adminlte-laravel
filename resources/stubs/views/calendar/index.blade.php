@extends('adminlte::page')

@section('title', __('adminlte.calendar'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.calendar') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.calendar') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row g-3">
        {{-- Sidebar: draggable events --}}
        <div class="col-lg-3">
            <x-adminlte-card icon="bi bi-list-task" title="Draggable events">
                <p class="text-secondary small mb-3">Drag an event to the calendar to schedule it.</p>

                <div id="external-events">
                    <div class="draggable-event badge text-bg-primary p-2 mb-2 d-block text-start" data-color="#0d6efd">
                        <i class="bi bi-grip-vertical me-1" aria-hidden="true"></i> Team standup
                    </div>
                    <div class="draggable-event badge text-bg-success p-2 mb-2 d-block text-start" data-color="#198754">
                        <i class="bi bi-grip-vertical me-1" aria-hidden="true"></i> Customer call
                    </div>
                    <div class="draggable-event badge text-bg-warning p-2 mb-2 d-block text-start" data-color="#ffc107">
                        <i class="bi bi-grip-vertical me-1" aria-hidden="true"></i> Design review
                    </div>
                    <div class="draggable-event badge text-bg-info p-2 mb-2 d-block text-start" data-color="#0dcaf0">
                        <i class="bi bi-grip-vertical me-1" aria-hidden="true"></i> 1:1 with manager
                    </div>
                    <div class="draggable-event badge text-bg-danger p-2 d-block text-start" data-color="#dc3545">
                        <i class="bi bi-grip-vertical me-1" aria-hidden="true"></i> Release window
                    </div>
                </div>

                <hr>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="remove-after-drop">
                    <label class="form-check-label small" for="remove-after-drop">
                        Remove from list after dropping
                    </label>
                </div>
            </x-adminlte-card>
        </div>

        {{-- Calendar --}}
        <div class="col-lg-9">
            <x-adminlte-card bodyClass="p-2">
                <x-adminlte-calendar :events="route('adminlte.calendar.feed')" height="700px" />

                <x-slot name="footer">
                    <span class="text-secondary small">
                        Powered by
                        <a href="https://fullcalendar.io/" target="_blank" rel="noopener">FullCalendar 6</a>
                    </span>
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>

    @push('css')
        <style>
            .fc-event { cursor: pointer; }
            .draggable-event { cursor: grab; user-select: none; }
        </style>
    @endpush
@stop
