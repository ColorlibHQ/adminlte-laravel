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
@php app(\ColorlibHQ\AdminLte\Plugins\PluginManager::class)->enable('apexcharts'); @endphp
```

## Config shape (`css`/`js` as string or array)

Each plugin is defined under the `plugins` key:

```php
'plugins' => [
    'apexcharts' => [
        'enabled' => false,
        'js' => 'vendor/apexcharts/apexcharts.min.js',
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
  then the world-map data file.)
- A plugin may omit `css` or `js` entirely (e.g. ApexCharts is JS-only).

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
| `<x-adminlte-chart>` | `apexcharts` |
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
| `apexcharts` | — | `vendor/apexcharts/apexcharts.min.js` |
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
| `apexcharts/dist/apexcharts.min.js` | `apexcharts/apexcharts.min.js` |
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

The published entry point `resources/js/adminlte.js` (from `app.js.stub`) imports
Bootstrap, OverlayScrollbars and `admin-lte`, then feature-detects the
globally-loaded plugin libraries and wires them up on DOM-ready. Because the
libraries are loaded as global `<script>` tags via `@pluginScripts`, each
initializer no-ops if its global is absent:

| Initializer | Trigger attribute | Notes |
| --- | --- | --- |
| `initCharts()` | `[data-apexchart]` | Reads `data-apexchart-config` (JSON), renders an ApexCharts instance. Wrapped in try/catch so one bad config can't break other charts. |
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
