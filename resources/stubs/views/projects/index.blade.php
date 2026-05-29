@extends('adminlte::page')

@section('title', __('adminlte.projects'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.projects') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-kanban" title="{{ __('adminlte.all_projects') }}" bodyClass="p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>{{ __('adminlte.name') }}</th>
                        <th>{{ __('adminlte.status') }}</th>
                        <th style="width: 25%;">{{ __('adminlte.progress') }}</th>
                        <th>{{ __('adminlte.due_date') }}</th>
                        <th class="text-end">{{ __('adminlte.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>
                                <strong>{{ $project->name }}</strong>
                                <div class="small text-muted text-truncate" style="max-width: 320px;">{{ $project->description }}</div>
                            </td>
                            <td><span class="badge bg-{{ $project->statusColor() }}">{{ __('adminlte.status_'.$project->status) }}</span></td>
                            <td>
                                <x-adminlte-progress :value="$project->progress" :theme="$project->statusColor()" />
                            </td>
                            <td class="text-muted">{{ $project->due_date?->format('d M Y') ?? '—' }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('adminlte.projects.destroy', $project) }}"
                                      onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="{{ __('adminlte.delete') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">{{ __('adminlte.no_projects') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            {{ $projects->links() }}
        </x-slot>
    </x-adminlte-card>
@stop
