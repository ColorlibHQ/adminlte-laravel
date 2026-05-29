@extends('adminlte::page')

@section('title', __('adminlte.settings'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.settings') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-md-8">
            <x-adminlte-card icon="bi bi-gear" title="{{ __('adminlte.general_settings') }}">
                <form method="POST" action="{{ route('adminlte.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <x-adminlte-input name="name" label="{{ __('adminlte.name') }}" value="{{ $user->name }}" required />

                    <x-adminlte-select name="locale" label="{{ __('adminlte.language') }}">
                        @foreach (['en' => 'English', 'de' => 'Deutsch', 'es' => 'Español', 'fr' => 'Français'] as $code => $name)
                            <option value="{{ $code }}" @selected(session('locale', app()->getLocale()) === $code)>{{ $name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> {{ __('adminlte.save') }}
                    </button>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop
