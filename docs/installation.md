# Installation

AdminLTE 4 for Laravel installs as a Composer package and uses a Vite-first
asset pipeline (no precompiled CSS/JS shipped in your app).

## Requirements

| Requirement | Version |
|---|---|
| PHP | 8.3+ |
| Laravel | 13 |
| Node.js | 18+ (for the Vite asset pipeline) |

## 1. Require the package

```bash
composer require colorlibhq/adminlte-laravel
```

## 2. Run the installer

```bash
php artisan adminlte:install
```

This will:

- Publish `config/adminlte.php`.
- Drop the Vite entry stubs into `resources/css/adminlte.css` and
  `resources/js/adminlte.js`.
- Offer to `npm install` the frontend dependencies, pinned to the major
  versions the package is tested against:
  `admin-lte@^4.0`, `bootstrap@^5.3`, `@popperjs/core@^2.11`,
  `overlayscrollbars@^2.0`, `bootstrap-icons@^1.13`, `apexcharts@^5.0`,
  `jsvectormap@^1.7`, `fullcalendar@^6.1`, `sortablejs@^1.15`, `sass@^1.77`.
- Copy the plugin vendor files (ApexCharts, jsVectorMap, FullCalendar,
  SortableJS, plus the AdminLTE RTL stylesheet) into `public/vendor/`.

The optional plugins (Flatpickr, Tom Select, Tabulator, Quill) are disabled
by default and not installed — add them only if you enable them in
`config/adminlte.php`:

```bash
npm install -D flatpickr@^4.6 tom-select@^2.4 tabulator-tables@^6.0 quill@^2.0
```

See [plugins.md](plugins.md) for details.

See [commands.md](commands.md) for all installer options
(`--only=config|views|assets|lang`, `--force`, `--no-interaction-deps`).

## 3. Wire Vite

Add the two entry files to your `vite.config.js`:

```js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/adminlte.css',
                'resources/js/adminlte.js',
            ],
            refresh: true,
        }),
    ],
})
```

## 4. Build assets

```bash
npm run dev      # development (HMR)
# or
npm run build    # production
```

## 5. Create your first page

```blade
{{-- resources/views/dashboard.blade.php --}}
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h3 class="mb-0">Dashboard</h3>
@stop

@section('content')
    <x-adminlte-info-box title="Orders" text="150" icon="bi bi-bag" theme="primary" />
@stop
```

```php
// routes/web.php
Route::view('/', 'dashboard')->middleware('auth');
```

## 6. Verify

```bash
php artisan adminlte:status
```

Reports which resources are installed (config, stubs, published views,
npm packages, plugin vendor files, scaffolded sections).

## Next steps

- [Configuration reference](configuration.md)
- [Sidebar menu](menu.md)
- [Blade components](components.md)
- [Scaffolding application sections](scaffolding.md)
- [Authentication](authentication.md)
