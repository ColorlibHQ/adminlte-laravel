# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**AdminLTE 4 for Laravel** (`colorlibhq/adminlte-laravel`) is the official Laravel package integration of AdminLTE 4 (Bootstrap 5.3, vanilla JS, no jQuery). It provides:

- Config-driven sidebar menu with permissions, active states, badges
- 40 Blade components (widgets, forms, charts, calendar, kanban, wizard, modals)
- Scaffolding system (`adminlte:scaffold`) for 18 DB-backed app sections
- Dependency-free RBAC (roles, permissions, middleware, permission-aware Gate)
- Auth scaffolding (`adminlte:make-auth`) for plain/Breeze/Fortify
- Plugin system for lazy-loading JS libraries (Flatpickr, Tom Select, Tabulator, Quill, ApexCharts, jsVectorMap, FullCalendar, SortableJS)
- i18n with 9 locales (en, de, es, fr, it, ja, pt_BR, ru, zh), RTL support
- Bundled demo pages and in-app docs (served at `/docs`)
- Vite-first asset pipeline

This is a **Composer package**, not a Laravel application. Requires PHP ^8.3 and Laravel (illuminate) ^13.0. Tests run against Orchestra Testbench — the package is never "run" directly; it's consumed via `composer require colorlibhq/adminlte-laravel` + `php artisan adminlte:install`.

## Development Commands

```bash
composer test       # PHPUnit
composer lint       # Pint check only (what CI runs)
composer fix        # Pint, applying fixes
composer analyse    # PHPStan level 8 (bakes in --memory-limit=1G — the bare
                    # `vendor/bin/phpstan` exhausts PHP's default 128M limit)
composer check      # lint + analyse + test (the full CI sequence)

# Run a single test class/method
vendor/bin/phpunit tests/SmokeTest.php
vendor/bin/phpunit tests/SmokeTest.php --filter testComponentsRenderWithoutErrors
```

CI (`.github/workflows/tests.yml`) runs on PHP 8.3 + 8.4 + 8.5 against Laravel 13 / Testbench 11, in this order: **composer lint → composer analyse → composer test**. All three must pass.

## Architecture & Key Concepts

### Service Provider (`AdminLteServiceProvider`)

Single entry point. On boot it:

- Registers 40 Blade components under the `adminlte-` prefix (e.g. `<x-adminlte-card>`), from the `$components` map at the top of the class
- Registers the `AdminLte` menu-builder singleton (aliased `adminlte`) and the `PluginManager` singleton
- Registers `@pluginStyles` / `@pluginScripts` Blade directives — these emit PHP that runs at **request time**, so plugins enabled by components during render are reflected
- Registers translations both under the `adminlte::` namespace **and** as a default-namespace path, so views can use plain `__('adminlte.key')` without publishing
- Registers demo routes (`/demo/*`, toggle with `config('adminlte.demo')`) and in-app docs routes (`/docs/{page}`, renders the markdown in `docs/` with the AdminLTE layout)
- Opportunistically wires RBAC for the consuming app: model policies, `role`/`permission` middleware aliases, and a permission-aware `Gate::before` — all guarded by `class_exists` on `App\...` classes that only exist after `adminlte:scaffold rbac`
- Listens to auth events (Login/Logout/Failed) and writes them via `ActivityLogger`, which **no-ops when the `activity_log` table is absent**

### Artisan Commands (`src/Console/`)

| Command | Purpose |
| --- | --- |
| `adminlte:install` | Publish config + Vite stubs, wire Vite, prompt for npm deps (`--only=config\|views\|assets\|lang`) |
| `adminlte:scaffold {section}` | Publish a DB-backed section into the consuming app (`--all`, `--force`, `--seed`) |
| `adminlte:make-auth` | Auth controllers/routes (`--type=plain\|breeze\|fortify`) with hardening |
| `adminlte:status` | Show install state |

### Scaffolding System (`ScaffoldCommand` + `resources/stubs/`)

The largest subsystem. `ScaffoldCommand` holds a declarative `$manifest` mapping each of 18 sections (dashboard, mailbox, chat, kanban, calendar, projects, file-manager, profile, settings, invoice, pricing, faq, notifications, api, impersonation, activity-log, realtime, rbac) to what it publishes: migrations, models, factories, controllers, Form Requests, policies, seeders, feature tests, views, and route stubs. All stubs live in `resources/stubs/` as `.php.stub` files organized by type (`models/`, `controllers/`, `migrations/`, `policies/`, `rbac/`, `realtime/`, etc.). To change what a section generates, edit both the manifest and the stub files.

### Menu System (`AdminLte` + `MenuItemHelper`)

- **`AdminLte` class** (singleton): builds and filters the sidebar/navbar menu from `config('adminlte.menu')`
- Menu items flow through a **filter pipeline** (`config('adminlte.filters')`), in order:
  1. `SearchFilter` — normalizes menu data
  2. `GateFilter` — filters by authorization (`can` key; works with the RBAC `Gate::before`)
  3. `HrefFilter` — resolves routes to URLs
  4. `ActiveFilter` — marks current page as active
- Singleton ensures runtime `addAfter()` calls persist for the request (reset next request)
- Scoped retrieval: `menu('sidebar')`, `menu('navbar-left')`, `menu('navbar-right')`
- The filter pipeline is the single source of truth for menu rendering logic

### Plugin System (`PluginManager`)

- Lazy-loads optional JS/CSS libraries; config under `config('adminlte.plugins')` (flatpickr, tom_select, tabulator, quill, apexcharts, jsvectormap, fullcalendar, sortablejs)
- Plugin-backed components call `app(PluginManager::class)->enable('plugin-name')` in their **constructor** — rendering the component is what triggers asset loading
- `renderStyles()`/`renderScripts()` append a cache-busting `?v=<filemtime>` to asset URLs (skipped when the file isn't on disk, e.g. in tests)
- Bundled default asset paths are patched into config entries that omit `css`/`js` keys

### Blade Components

**PHP classes:** `src/View/Components/{Form,Widget,Tool}/` → **views:** `resources/views/components/{form,widget,tool}/` (namespaced `adminlte::`)

- **Widget** (21): Card, SmallBox, InfoBox, Alert, Callout, Progress, Timeline, ProgressGroup, DescriptionBlock, ProfileCard, Ratings, NavNotifications, NavMessages, NavTasks, DirectChat, Toast, Tabs/Tab, Accordion/AccordionItem, Breadcrumb
- **Form** (9): Input, InputSwitch, InputColor, InputFile, InputFlatpickr, InputTomSelect, Textarea, Select, Button
- **Tool** (10): Modal, Datatable, Editor, Chart, VectorMap, Calendar, Kanban, Sortable, Wizard/WizardStep

**Pattern:** constructor parameters become tag attributes; public helper methods (e.g. `cardClass()`) compute dynamic CSS/conditional content; `render()` returns the matching `adminlte::components.*` view. Plugin-backed components additionally call `PluginManager::enable()` in the constructor.

### Support Classes (`src/Support/`)

- **`ActivityLogger`** — static `log()` into the scaffolded `activity_log` table; silently no-ops if the table doesn't exist, so package code can call it unconditionally
- **`NavbarData`** — feeds the navbar notification/message dropdowns from real DB tables when scaffolded, falling back to demo data otherwise

## Testing

- **Base:** `tests/TestCase.php` extends Orchestra Testbench and registers only `AdminLteServiceProvider`
- **Files:** `SmokeTest.php` (component rendering, menu filtering, auth views), `PluginSystemTest.php`, `WidgetComponentTest.php`, `ScaffoldCommandTest.php`, `MakeAuthCommandTest.php`
- Component tests render the namespaced view directly and assert on output strings:

```php
$view = view('adminlte::components.widget.card', [...])->render();
$this->assertStringContainsString('card', $view);
```

- Scaffold/auth command tests run the artisan command in Testbench and assert published files exist/contain expected content

## Common Development Patterns

### Adding a New Component

1. PHP class in `src/View/Components/{Category}/YourComponent.php` extending `Illuminate\View\Component`
2. Blade view in `resources/views/components/{category}/your-component.blade.php`
3. Register in the `$components` array in `AdminLteServiceProvider` (`'your-component' => ...` → `<x-adminlte-your-component>`)
4. Test rendering in `tests/WidgetComponentTest.php` or similar

### Adding a Menu Filter

1. Implement `FilterInterface` in `src/Menu/Filters/` — `transform(array $item): ?array`, return null to drop the item
2. Append to `'filters'` in `config/adminlte.php` (order matters)

### Adding a Plugin

1. Add entry under `'plugins'` in `config/adminlte.php` (`enabled`, `css`, `js`)
2. Create a component whose constructor calls `app(PluginManager::class)->enable('your-lib')`
3. Test via `@pluginStyles`/`@pluginScripts` output in `PluginSystemTest.php`

### Adding a Scaffold Section

1. Add `.php.stub` files under the matching `resources/stubs/` subdirectories
2. Add the section to `$sections` and `$manifest` in `ScaffoldCommand`
3. Add a feature test in `tests/ScaffoldCommandTest.php`
4. Document in `docs/scaffolding.md` (docs are user-facing — served in-app at `/docs`)

## Code Style & Standards

- **PHP:** PSR-12 via Pint; strict types and explicit return types
- **Static analysis:** PHPStan level 8 via Larastan (`phpstan.neon`; `view('adminlte::...')` view-string errors are intentionally ignored because PHPStan doesn't boot the provider)
- **Naming:** camelCase methods, kebab-case Blade component tags and view names

## Important Notes

- **This is a package**, not an app — never assume an `app/` directory; consuming-app classes (`App\Models\...`) are referenced as strings and guarded with `class_exists`
- **Menu is a singleton** — runtime mutations persist per-request only
- **Plugins are lazy** — assets load only if a rendered component enables them
- **`docs/` is dual-purpose** — GitHub docs *and* rendered in-app at `/docs`; keep markdown links relative (`foo.md`), the docs route rewrites them
- **Demo pages** under `resources/views/demo/` mirror the AdminLTE showcase and back the live demo at laravel.adminlte.io
- **All 9 locales must stay complete** — when adding a translatable string, add the key to every file in `resources/lang/`; verify with `php -r '$en=require "resources/lang/en/adminlte.php"; foreach(["de","es","fr","it","ja","pt_BR","ru","zh"] as $l) print $l.": ".count(array_diff_key($en, require "resources/lang/$l/adminlte.php")).PHP_EOL;'` (all zeros)
- **`config('adminlte.logo')` / footer keys render unescaped** (`{!! !!}`) by design — they must only ever hold trusted hardcoded markup; never route user input into them
