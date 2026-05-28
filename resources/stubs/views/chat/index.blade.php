@extends('adminlte::page')
@section('title', 'Chat')
@section('content')
    <div class="row"><div class="col-md-12">
        <x-adminlte-direct-chat title="Chat" :items="[]" />
    </div></div>
@stop
