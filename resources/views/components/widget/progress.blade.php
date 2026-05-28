<div {{ $attributes->merge(['class' => 'progress']) }}
     role="progressbar"
     aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100"
     @isset($height) style="height: {{ $height }}" @endisset>
    <div class="{{ $barClass() }}" style="width: {{ $value }}%">
        @if ($showLabel){{ $value }}%@endif
    </div>
</div>
