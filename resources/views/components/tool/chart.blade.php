{{-- Rendered by the chartjs plugin's preset (public/vendor/adminlte/js/charts.js). --}}
<div class="adminlte-chart" style="position: relative; height: {{ $height }}">
    <canvas id="{{ $id }}"
            data-adminlte-chart
            data-adminlte-chart-config="{{ $chartConfig() }}"></canvas>
</div>
