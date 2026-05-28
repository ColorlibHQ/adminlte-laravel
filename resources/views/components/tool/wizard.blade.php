<div @if ($class) class="{{ $class }}" @endif>
    <ul class="steps">
        @for ($i = 1; $i <= $steps; $i++)
            <li class="step-item">
                <span class="step-number">{{ $i }}</span>
            </li>
        @endfor
    </ul>
    <form id="{{ $id }}" class="wizard-form">
        {{ $slot }}
    </form>
</div>
