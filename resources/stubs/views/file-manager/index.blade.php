@extends('adminlte::page')

@section('title', __('adminlte.file_manager'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.file_manager') }}</h1>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-md-3">
            <x-adminlte-card title="{{ __('adminlte.upload') }}" icon="bi bi-cloud-arrow-up">
                <form method="POST" action="{{ route('adminlte.file-manager.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="path" value="{{ $path }}">
                    <input type="file" name="file" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload me-1"></i> {{ __('adminlte.upload') }}
                    </button>
                </form>
            </x-adminlte-card>
        </div>

        <div class="col-md-9">
            <x-adminlte-card icon="bi bi-folder" title="{{ $path ?: '/' }}" bodyClass="p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <tbody>
                            @foreach ($directories as $dir)
                                <tr>
                                    <td style="width: 2rem;"><i class="bi bi-folder-fill text-warning"></i></td>
                                    <td><a href="{{ route('adminlte.file-manager.index', ['path' => $dir]) }}">{{ basename($dir) }}</a></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            @forelse ($files as $file)
                                <tr>
                                    <td><i class="bi bi-file-earmark"></i></td>
                                    <td>{{ $file['name'] }}</td>
                                    <td class="text-muted small">{{ number_format($file['size'] / 1024, 1) }} KB</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('adminlte.file-manager.destroy') }}" class="d-inline"
                                              onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="path" value="{{ $file['path'] }}">
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                @if ($directories->isEmpty())
                                    <tr><td colspan="4" class="text-center text-muted py-4">{{ __('adminlte.no_files') }}</td></tr>
                                @endif
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
