@extends('adminlte::page')

@section('title', __('adminlte.file_manager'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.file_manager') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.file_manager') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    @php
        $iconFor = function (string $name): array {
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            return match (true) {
                in_array($ext, ['pdf']) => ['bi-file-earmark-pdf-fill', 'text-danger'],
                in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif', 'bmp']) => ['bi-file-earmark-image-fill', 'text-primary'],
                in_array($ext, ['doc', 'docx']) => ['bi-file-earmark-word-fill', 'text-info'],
                in_array($ext, ['xls', 'xlsx', 'csv']) => ['bi-file-earmark-spreadsheet-fill', 'text-success'],
                in_array($ext, ['ppt', 'pptx']) => ['bi-file-earmark-slides-fill', 'text-warning'],
                in_array($ext, ['zip', 'rar', 'gz', '7z', 'tar']) => ['bi-file-earmark-zip-fill', 'text-secondary'],
                in_array($ext, ['js', 'ts', 'tsx', 'jsx', 'php', 'html', 'css', 'json', 'xml', 'vue', 'py', 'rb']) => ['bi-file-earmark-code-fill', 'text-primary'],
                in_array($ext, ['mp3', 'wav', 'ogg', 'flac']) => ['bi-file-earmark-music-fill', 'text-purple'],
                in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']) => ['bi-file-earmark-play-fill', 'text-danger'],
                in_array($ext, ['txt', 'md']) => ['bi-file-earmark-text-fill', 'text-secondary'],
                default => ['bi-file-earmark-fill', 'text-secondary'],
            };
        };
        $totalItems = $directories->count() + $files->count();
    @endphp

    <div class="row g-3">
        {{-- Sidebar: quick links + upload --}}
        <div class="col-lg-3">
            <x-adminlte-card title="{{ __('adminlte.upload') }}" icon="bi bi-cloud-arrow-up">
                <form method="POST" action="{{ route('adminlte.file-manager.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="path" value="{{ $path }}">
                    <input type="file" name="file" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-cloud-upload me-1" aria-hidden="true"></i> {{ __('adminlte.upload') }}
                    </button>
                </form>
            </x-adminlte-card>

            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="{{ route('adminlte.file-manager.index', ['path' => '']) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $path === '' || $path === null ? 'active' : '' }}">
                        <span>
                            <i class="bi bi-house me-2" aria-hidden="true"></i>
                            {{ __('adminlte.home') }}
                        </span>
                    </a>
                    @foreach ($directories as $dir)
                        <a href="{{ route('adminlte.file-manager.index', ['path' => $dir]) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ps-4">
                            <span>
                                <i class="bi bi-folder me-2" aria-hidden="true"></i>
                                {{ basename($dir) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <p class="fw-semibold mb-2 small">
                        <i class="bi bi-files me-1" aria-hidden="true"></i>
                        {{ __('adminlte.file_manager') }}
                    </p>
                    <small class="text-secondary">{{ trans_choice('{0}No items|{1}1 item|[2,*]:count items', $totalItems, ['count' => $totalItems]) }}</small>
                </div>
            </div>
        </div>

        {{-- Main: file browser --}}
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header d-flex flex-wrap gap-2 align-items-center">
                    <nav aria-label="breadcrumb" class="flex-grow-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('adminlte.file-manager.index', ['path' => '']) }}">
                                    <i class="bi bi-house" aria-hidden="true"></i>
                                </a>
                            </li>
                            @if ($path)
                                @php($crumbParts = explode('/', trim($path, '/')))
                                @php($crumbAccum = '')
                                @foreach ($crumbParts as $crumb)
                                    @php($crumbAccum = ltrim($crumbAccum . '/' . $crumb, '/'))
                                    @if ($loop->last)
                                        <li class="breadcrumb-item active" aria-current="page">{{ $crumb }}</li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('adminlte.file-manager.index', ['path' => $crumbAccum]) }}">{{ $crumb }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    @if ($totalItems === 0)
                        <div class="text-center text-secondary py-5">
                            <i class="bi bi-folder-x display-4 d-block mb-3" aria-hidden="true"></i>
                            {{ __('adminlte.no_files') }}
                        </div>
                    @else
                        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3">
                            {{-- Folders --}}
                            @foreach ($directories as $dir)
                                <div class="col">
                                    <a href="{{ route('adminlte.file-manager.index', ['path' => $dir]) }}"
                                       class="card text-center text-decoration-none text-body h-100 position-relative">
                                        <div class="card-body d-flex flex-column justify-content-center pb-2">
                                            <i class="bi bi-folder-fill text-warning display-5 mb-3" aria-hidden="true"></i>
                                            <p class="card-title fw-medium small text-break mb-0">{{ basename($dir) }}</p>
                                        </div>
                                        <div class="card-footer bg-transparent small text-secondary py-2">
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                <span class="text-truncate">
                                                    <i class="bi bi-folder me-1" aria-hidden="true"></i>
                                                    {{ __('adminlte.folders') }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            {{-- Files --}}
                            @foreach ($files as $file)
                                @php([$icon, $iconColor] = $iconFor($file['name']))
                                <div class="col">
                                    <div class="card text-center h-100 position-relative">
                                        <div class="card-body d-flex flex-column justify-content-center pb-2">
                                            <i class="bi {{ $icon }} {{ $iconColor }} display-5 mb-3" aria-hidden="true"></i>
                                            <p class="card-title fw-medium small text-break mb-0" title="{{ $file['name'] }}">{{ $file['name'] }}</p>
                                        </div>
                                        <div class="card-footer bg-transparent small text-secondary py-2">
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                <span class="text-truncate" title="{{ number_format($file['size'] / 1024, 1) }} KB">
                                                    {{ number_format($file['size'] / 1024, 1) }} KB
                                                </span>
                                                <form method="POST" action="{{ route('adminlte.file-manager.destroy') }}" class="d-inline"
                                                      onsubmit="return confirm('{{ __('adminlte.confirm_delete') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                                                    <button class="btn btn-sm btn-link text-danger p-0" title="{{ __('adminlte.confirm_delete') }}">
                                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card-footer text-secondary small">
                    {{ trans_choice('{0}No items|{1}1 item|[2,*]:count items', $totalItems, ['count' => $totalItems]) }}
                </div>
            </div>
        </div>
    </div>
@stop
