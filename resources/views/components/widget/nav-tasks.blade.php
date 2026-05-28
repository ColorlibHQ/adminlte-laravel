<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-check2-square"></i>
        @if (count($tasks) > 0)
            <span class="badge badge-{{ $badgeColor }} navbar-badge">{{ count($tasks) }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-header">{{ count($tasks) }} {{ __('adminlte.tasks') }}</span>
        <div class="dropdown-divider"></div>
        @forelse ($tasks as $task)
            <a href="{{ $task['url'] ?? '#' }}" class="dropdown-item">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $task['title'] ?? 'Task' }}</h6>
                        @if ($task['progress'] ?? null)
                            <div class="progress progress-sm" style="height: 8px;">
                                <div class="progress-bar bg-{{ $task['color'] ?? 'primary' }}"
                                     style="width: {{ $task['progress'] }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <a href="#" class="dropdown-item">{{ __('adminlte.no_tasks') }}</a>
        @endforelse
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">{{ __('adminlte.see_all_tasks') }}</a>
    </div>
</li>
