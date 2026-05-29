@extends('adminlte::page')

@section('title', __('adminlte.kanban'))

@section('content_header')
    <h1 class="m-0">{{ $board->name ?? __('adminlte.kanban') }}</h1>
@stop

@section('content')
    @if ($board)
        @php
            $lanes = $board->lanes->map(fn ($lane) => [
                'name' => $lane->name,
                'cards' => $lane->cards->map(fn ($card) => [
                    'id' => $card->id,
                    'title' => $card->title,
                    'description' => $card->description,
                    'color' => $card->color,
                ])->all(),
            ])->all();
        @endphp

        <x-adminlte-kanban :lanes="$lanes" />
    @else
        <x-adminlte-card>
            <p class="text-muted text-center m-0">{{ __('adminlte.no_board') }}</p>
        </x-adminlte-card>
    @endif
@stop
