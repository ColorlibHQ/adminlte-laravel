<div class="progress-group">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>{{ $label }}</span>
        @if ($showPercentage)
            <span class="badge bg-{{ $color }}">{{ $percentage() }}%</span>
        @endif
    </div>
    <div class="progress h-3">
        <div class="progress-bar bg-{{ $color }}" style="width: {{ $percentage() }}%"></div>
    </div>
</div>
