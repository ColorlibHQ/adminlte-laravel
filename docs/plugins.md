# Plugins

AdminLTE 4 for Laravel lazy-loads a handful of optional JavaScript libraries.
A plugin's assets are only emitted on pages that actually use it, keeping the
base layout lean. This is managed by the `PluginManager` singleton and the
`@pluginStyles` / `@pluginScripts` Blade directives.

## How `PluginManager` works

`PluginManager` (`src/Plugins/PluginManager.php`) is registered as a singleton
seeded from the `plugins` array in `config/adminlte.php`. Because it is a
singleton, plugin state set during a request (for example by a component)
persists until the directives render.

Public API:

| Method | Description |
| --- | --- |
| `enable(string $plugin)` | Mark a plugin enabled for this request (only if it exists in config). |
| `disable(string $plugin)` | Mark a plugin disabled for this request. |
| `isEnabled(string $plugin)` | Whether the plugin is enabled (request override, else config `enabled`). |
| `has(string $plugin)` | Whether the plugin key exists in config. |
| `getCss(string $plugin)` / `getJs(string $plugin)` | Raw configured asset value when enabled, else `null`. |
| `getEnabledPlugins()` | All currently enabled plugins keyed by name. |
| `renderStyles()` / `renderScripts()` | HTML `<link>` / `<script>` tags for every enabled plugin. |

You can drive it directly from a view or service if needed:

```blade
@php app(\ColorlibHQ\AdminLte\Plugins\PluginManager::class)->enable('chartjs'); @endphp
```

## Config shape (`css`/`js` as string or array)

Each plugin is defined under the `plugins` key:

```php
'plugins' => [
    'chartjs' => [
        'enabled' => false,
        'js' => [
            'vendor/chartjs/chart.umd.min.js',
            'vendor/adminlte/js/charts.js',
        ],
    ],
    'jsvectormap' => [
        'enabled' => false,
        'css' => 'vendor/jsvectormap/jsvectormap.min.css',
        'js' => [
            'vendor/jsvectormap/jsvectormap.min.js',
            'vendor/jsvectormap/maps/world.js',
        ],
    ],
],
```

- `enabled` — whether the plugin loads by default on every page. Most ship as
  `false` and are turned on per-page by components.
- `css` and `js` accept **either a single string or an array of strings**.
  `renderStyles()` / `renderScripts()` cast each to an array and emit one tag
  per file, in order. (Order matters — e.g. jsVectorMap loads the library first,
  then the world-map data file, and Chart.js loads before the AdminLTE preset.)
- A plugin may omit `css` or `js` entirely (e.g. Chart.js is JS-only).

All paths are passed through Laravel's `asset()` helper, so they resolve
relative to `public/`.

## The `@pluginStyles` / `@pluginScripts` directives

These directives are registered in `AdminLteServiceProvider` and execute at
**request time, not compile time**:

```php
Blade::directive('pluginStyles', fn () => "<?php echo app('...PluginManager')->renderStyles(); ?>");
Blade::directive('pluginScripts', fn () => "<?php echo app('...PluginManager')->renderScripts(); ?>");
```

The master layout places `@pluginStyles` in `<head>` and `@pluginScripts` at the
bottom of `<body>`. Because they evaluate during rendering, any plugin a
component enabled earlier in the same request is included.

## Components auto-enable their plugins

Plugin-backed components call `PluginManager::enable()` in their constructor, so
simply using the component on a page emits the right assets — no config or manual
calls required:

| Component | Plugin enabled |
| --- | --- |
| `<x-adminlte-input-flatpickr>` | `flatpickr` |
| `<x-adminlte-input-tom-select>` | `tom_select` |
| `<x-adminlte-datatable>` | `tabulator` |
| `<x-adminlte-editor>` | `quill` |
| `<x-adminlte-chart>` | `chartjs` |
| `<x-adminlte-vector-map>` | `jsvectormap` |
| `<x-adminlte-calendar>` | `fullcalendar` |
| `<x-adminlte-sortable>` | `sortablejs` |
| `<x-adminlte-kanban>` | `sortablejs` |

## Bundled plugins

| Key | CSS | JS |
| --- | --- | --- |
| `flatpickr` | `vendor/flatpickr/flatpickr.min.css` | `vendor/flatpickr/flatpickr.min.js` |
| `tom_select` | `vendor/tom-select/tom-select.bootstrap5.min.css` | `vendor/tom-select/tom-select.complete.min.js` |
| `tabulator` | `vendor/tabulator-tables/tabulator.min.css` | `vendor/tabulator-tables/tabulator.min.js` |
| `quill` | `vendor/quill/quill.snow.css` | `vendor/quill/quill.min.js` |
| `chartjs` | — | `vendor/chartjs/chart.umd.min.js`, `vendor/adminlte/js/charts.js` |
| `jsvectormap` | `vendor/jsvectormap/jsvectormap.min.css` | `vendor/jsvectormap/jsvectormap.min.js`, `vendor/jsvectormap/maps/world.js` |
| `fullcalendar` | — | `vendor/fullcalendar/index.global.min.js` |
| `sortablejs` | — | `vendor/sortablejs/sortablejs.min.js` |

> Note the config key for Tom Select is `tom_select` (underscore).

## How vendor files reach `public/vendor`

`php artisan adminlte:install` runs `copyVendorFiles()`
(`src/Console/InstallCommand.php`), which copies library files out of
`node_modules` into `public/vendor`. Keys are source paths relative to
`node_modules`; values are destination paths relative to `public/vendor`
(allowing a rename on copy). Missing sources are skipped silently.

| From `node_modules/...` | To `public/vendor/...` |
| --- | --- |
| `chart.js/dist/chart.umd.min.js` | `chartjs/chart.umd.min.js` |
| `jsvectormap/dist/jsvectormap.min.css` | `jsvectormap/jsvectormap.min.css` |
| `jsvectormap/dist/jsvectormap.min.js` | `jsvectormap/jsvectormap.min.js` |
| `jsvectormap/dist/maps/world.js` | `jsvectormap/maps/world.js` |
| `fullcalendar/index.global.min.js` | `fullcalendar/index.global.min.js` |
| `sortablejs/Sortable.min.js` | `sortablejs/sortablejs.min.js` |
| `flatpickr/dist/flatpickr.min.css` | `flatpickr/flatpickr.min.css` |
| `flatpickr/dist/flatpickr.min.js` | `flatpickr/flatpickr.min.js` |
| `tom-select/dist/css/tom-select.bootstrap5.min.css` | `tom-select/tom-select.bootstrap5.min.css` |
| `tom-select/dist/js/tom-select.complete.min.js` | `tom-select/tom-select.complete.min.js` |
| `tabulator-tables/dist/css/tabulator.min.css` | `tabulator-tables/tabulator.min.css` |
| `tabulator-tables/dist/js/tabulator.min.js` | `tabulator-tables/tabulator.min.js` |
| `quill/dist/quill.snow.css` | `quill/quill.snow.css` |
| `quill/dist/quill.js` | `quill/quill.min.js` |
| `admin-lte/dist/css/adminlte.rtl.min.css` | `adminlte/css/adminlte.rtl.min.css` |

Quill 2 ships a single minified UMD build named `quill.js`, so it's renamed on
copy to the `quill.min.js` path the config points at. The last entry is the RTL
stylesheet loaded by the master layout when `layout_rtl` is on. The FullCalendar
stylesheet ships inside this package (`resources/vendor/`) rather than npm, and
is copied from there.

### Adding an optional plugin after install

Flatpickr, Tom Select, Tabulator and Quill are disabled by default and aren't
part of the installer's npm step. Adding one takes **two** commands:

```bash
npm install -D quill@^2.0          # 1. fetch the library
php artisan adminlte:install --only=assets   # 2. copy it into public/vendor
```

Missing sources are skipped silently, so `--only=assets` is safe to re-run at
any time and picks up whatever you've installed since.

Skipping step 2 is the classic failure: `@pluginScripts` emits
`<script src="/vendor/quill/quill.min.js">`, the file isn't there, the browser
404s, and `<x-adminlte-editor>` renders an empty box with nothing in the Laravel
log to explain it. `php artisan adminlte:status` lists each optional plugin so
you can see at a glance which ones are actually in place.

## The `app.js` initializers

## Charts (Chart.js)

Charts use [Chart.js](https://www.chartjs.org) 4 (MIT). The `chartjs` plugin loads
two files: Chart.js itself and `vendor/adminlte/js/charts.js`, a small preset
this package ships (copied by `adminlte:install` from `resources/vendor/`). The
preset:

- sets `Chart.defaults` from the page's CSS variables (`--bs-body-font-family`,
  `--bs-secondary-color`, `--bs-border-color-translucent`, …): subtle
  horizontal gridlines, no vertical grid, rounded bars, smooth lines, point-style
  legends and Bootstrap-style tooltips;
- re-themes every chart on the page when the colour mode changes (the navbar
  light/dark/auto toggle sets `data-bs-theme`) or the text direction flips
  (legends and tooltips follow RTL);
- renders every `<x-adminlte-chart>` (`canvas[data-adminlte-chart]`, JSON in
  `data-adminlte-chart-config`); one bad config logs a warning and leaves the
  other charts alone;
- resizes charts when a tab, modal, collapse or AdminLTE card is shown, so
  charts in hidden panes are never blank.

Series without their own colours take the theme palette (`--bs-primary`,
`--bs-teal`, `--bs-warning`, `--bs-pink`, `--bs-purple`, …). A colour written as
`'var(--bs-success)'` stays live: it is re-read on every update, so it follows
dark mode and `primary_color`.

For charts you write by hand, enable the plugin and use `window.AdminLteCharts`:

```blade
@php app(\ColorlibHQ\AdminLte\Plugins\PluginManager::class)->enable('chartjs'); @endphp

<div id="revenue" style="height: 300px"></div>
<div id="spark" style="width: 120px; height: 30px"></div>

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    AdminLteCharts.create('#revenue', {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar'],
        datasets: [{ label: 'Revenue', data: [12, 19, 15], borderColor: 'var(--bs-primary)', fill: 'origin' }],
      },
    })
    AdminLteCharts.sparkline('#spark', [5, 9, 7, 12], { color: 'var(--bs-success)', tooltip: true })
  })
</script>
@endpush
```

| Helper | Does |
| --- | --- |
| `create(elOrSelector, config)` | Renders a Chart.js config into a `<canvas>`, or into a container (a canvas is added; the container's height is the chart's height). Destroys a chart already on that canvas first. Returns the `Chart`. |
| `sparkline(elOrSelector, data, opts)` | Axis-less line (`opts`: `color`, `fill`, `tooltip`, `min`, `max`, `type`). |
| `color('var(--bs-primary)')` / `alpha(color, 0.3)` / `palette(i)` | Colour helpers. |
| `refresh()` / `init(scope)` | Re-theme all charts; render charts added to the DOM later. |

Because `Chart` is a global, `new Chart(canvas, config)` works too; those charts
pick up the theme defaults and live re-theming for colours they don't set.

The published entry point `resources/js/adminlte.js` (from `app.js.stub`) imports
Bootstrap, OverlayScrollbars and `admin-lte`, then feature-detects the
globally-loaded plugin libraries and wires them up on DOM-ready. Because the
libraries are loaded as global `<script>` tags via `@pluginScripts`, each
initializer no-ops if its global is absent:

| Initializer | Trigger attribute | Notes |
| --- | --- | --- |
| `initVectorMaps()` | `[data-jsvectormap]` | Requires an element `id`; reads `data-jsvectormap-config`. Warns if map data is missing. |
| `initCalendars()` | `[data-fullcalendar]` | Reads `data-fullcalendar-config`; renders a FullCalendar. |
| `initSortables()` | `[data-sortable]` and `[data-sortable-kanban]` | Generic lists read `data-sortable-options`; kanban lanes (`[data-sortable-group]`) share one group per board. |
| `initDatePickers()` | `[data-flatpickr]` | Reads `data-flatpickr-config`; attaches a Flatpickr instance to the input. |
| `initTomSelects()` | `[data-tom-select]` | Reads `data-tom-select-config`; upgrades the `<select>` to a Tom Select control. |
| `initDatatables()` | `[data-tabulator-config]` | Builds a Tabulator table from the JSON config (columns, data, layout). |
| `initEditors()` | `[data-quill]` | Reads `data-quill-config`, seeds the editor from the hidden input named by `data-quill-target`, and mirrors the editor's HTML back into that input on every change so a plain form POST submits it. An empty editor writes `''` rather than Quill's `<p><br></p>`, so `required` / `nullable` validation behaves. |
| `initTreeviewA11y()` | sidebar treeview items | Mirrors AdminLTE's `.menu-open` class onto the toggle link's `aria-expanded`, so screen readers track submenu state. |

Each initializer marks processed elements with a `data-*Ready` flag so they
aren't initialized twice. Invalid JSON in a config attribute is logged with a
warning and treated as an empty config.
