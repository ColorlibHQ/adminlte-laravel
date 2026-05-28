@extends('adminlte::page')
@section('content')
    <x-adminlte-kanban :lanes="[
        ['name' => 'To Do', 'cards' => [
            ['id' => 1, 'title' => 'Task 1'],
            ['id' => 2, 'title' => 'Task 2'],
        ]],
        ['name' => 'In Progress', 'cards' => [
            ['id' => 3, 'title' => 'Task 3'],
        ]],
    ]" />
@stop
