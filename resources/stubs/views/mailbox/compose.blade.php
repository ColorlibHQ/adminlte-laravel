@extends('adminlte::page')

@section('title', __('adminlte.compose'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.compose') }}</h1>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-pencil-square" title="{{ __('adminlte.compose_new') }}">
        <form method="POST" action="{{ route('adminlte.mailbox.store') }}">
            @csrf

            <x-adminlte-select name="to_user_id" label="{{ __('adminlte.to') }}">
                @foreach (\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                    <option value="{{ $user->id }}" @selected(old('to_user_id') == $user->id)>{{ $user->name }}</option>
                @endforeach
            </x-adminlte-select>

            <x-adminlte-input name="subject" label="{{ __('adminlte.subject') }}" :value="old('subject')" required />

            <x-adminlte-textarea name="body" label="{{ __('adminlte.message') }}" rows="8" required>{{ old('body') }}</x-adminlte-textarea>

            <x-slot name="footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i> {{ __('adminlte.send') }}
                </button>
                <a href="{{ route('adminlte.mailbox.index') }}" class="btn btn-secondary">{{ __('adminlte.cancel') }}</a>
            </x-slot>
        </form>
    </x-adminlte-card>
@stop
