# Changelog

All notable changes to `colorlibhq/adminlte-laravel` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed (Asset pipeline infrastructure)

- `@pluginStyles` / `@pluginScripts` now resolve enabled plugins at **request
  time** instead of compile time, so plugins auto-enabled by components (e.g.
  `<x-adminlte-chart>` enabling ApexCharts) are reliably injected.
- Removed the duplicate CDN Bootstrap Icons `<link>` from `master.blade.php`
  (icons now come solely from the Vite bundle, eliminating font conflicts).
- `adminlte:install` now installs the plugin npm packages (apexcharts,
  jsvectormap, fullcalendar, sortablejs) and copies their dist files into
  `public/vendor/*`, resolving the 404s that left charts/maps/calendar/kanban
  blank.
- `app.js` stub now instantiates ApexCharts, jsVectorMap, FullCalendar, and
  SortableJS from the `data-*` attributes the components emit — the missing
  link that made those components actually render.
- Tabs/Tab components: panes now push to a Blade stack so they render inside
  `.tab-content` instead of (invalidly) inside the nav `<ul>`.

### Changed (Quality)

- PHPStan level 8 is now fully clean (0 errors) across `src/`, via accurate
  generic array typehints, `json_encode(...) ?: '{}'` config fallbacks, and a
  scoped ignore for the package-namespaced `view()` false-positive.

## [0.7.0] - 2026-05-29

### Added (Milestone 4: RTL, Locales, Preloader & Polish)

- 6 new fully-translated locales: French, Italian, Portuguese (Brazil),
  Russian, Chinese, Japanese — all 9 locales now cover every key (German and
  Spanish brought to parity).
- Prebuilt RTL stylesheet (`adminlte.rtl.min.css`) published by the installer
  and loaded by `master.blade.php` when `layout_rtl` is enabled.
- Preloader partial with AdminLTE animation, gated by the `preloader` config.
- Theme generator demo page with live `data-bs-theme` preview and
  copy-to-clipboard config output.

## [0.6.0] - 2026-05-29

### Added (Milestone 3: Auth Scaffolding & Advanced Integration)

- `adminlte:make-auth` command: `--type=plain` publishes working
  Login/Register/ForgotPassword/ResetPassword controllers (modern Auth facade)
  and an idempotent auth route group wired to the package's auth views;
  `--type=breeze` / `--type=fortify` print integration guidance.
- `adminlte:status` gains checks for the RTL stylesheet, the four plugin
  vendor files, and scaffolded sections.
- `adminlte:install --only=lang` publishes language files.
- Theme generator page for visual customization and config output.

## [0.5.0] - 2026-05-29

### Added (Milestone 2: Scaffolding System)

- `adminlte:scaffold` command with interactive multi-select and
  `--all` / `--force` / `--seed` flags, driven by a declarative section manifest.
- **Full DB-backed scaffolding** for 5 sections — mailbox, chat, kanban,
  calendar, projects — each generating real migrations, Eloquent models,
  controllers, seeders (fake demo data), page views, and routes.
- Controller-only / static sections: file-manager (Laravel Storage), profile,
  settings, invoice, pricing, faq.
- Route registration injects an idempotent, auth-protected `/admin` route group
  (named `adminlte.*`) into `routes/web.php`.
- `ScaffoldCommandTest` asserts every manifest-referenced stub exists.

## [0.4.0] - 2026-05-28

### Added (Milestone 1: Component Parity)

- 7 new Widget components: DirectChat, Toast, Tabs, Tab, Accordion, AccordionItem, Breadcrumb
- 7 new Tool components: Chart (ApexCharts), VectorMap (jsVectorMap), Calendar (FullCalendar), Kanban (SortableJS), Sortable, Wizard, WizardStep
- 4 new plugin configurations: ApexCharts, jsVectorMap, FullCalendar, SortableJS
- 3 new auth views: lockscreen, login-v2 (floating labels), register-v2 (floating labels)
- 3 new error pages: 404, 500, maintenance on dedicated errors-master layout
- Config keys: `footer_left`, `footer_right`, `preloader`, `control_sidebar`, `control_sidebar_theme`
- Preloader and control sidebar partials
- Master view: `@pluginStyles` and `@pluginScripts` directives for auto-asset injection
- Footer: config-driven left/right text rendering
- 30+ new translation keys across English, German, Spanish

### Changed

- All 14 new components registered with auto-plugin enablement
- Component registration now includes 40 total Blade components (up from 26)

## [0.3.0] - 2026-05-28

### Added

- Multi-language support with lang files for English, German, Spanish (+ 7 stubs)
- Publish tag `adminlte-lang` for user customization
- All auth views and components use `__('adminlte.key')` pattern for translations
- Config-driven lazy-loading of optional JavaScript libraries via PluginManager
- Blade directives `@pluginStyles` / `@pluginScripts` for head/body injection
- 5 new widget components: timeline, progress-group, description-block, profile-card, ratings
- 4 plugin-enabled form components: input-flatpickr, input-tom-select, datatable, editor
- 3 navbar dropdown components: nav-notifications, nav-messages, nav-tasks
- RTL (right-to-left) layout support via `layout_rtl` config
- Expanded test coverage for plugin system, widget components, menu filters
- PHPStan static analysis (level 8) via Larastan in CI
- Demo dashboard view showcasing all components

### Changed

- Auth views migrated to use `__('adminlte.key')` pattern (from generic `__()`)

## [0.2.0] - 2026-05-28

### Added

- Three more Bootstrap-native form components (no external JS required):
  `<x-adminlte-input-switch>`, `<x-adminlte-input-color>`, `<x-adminlte-input-file>`.
- GitHub Actions CI: Pint + PHPUnit across PHP 8.3 / 8.4 on Laravel 13.

## [0.1.0] - 2026-05-28

### Added

- Initial public release. AdminLTE 4 integration for Laravel 13 / PHP 8.3+.
- Config-driven sidebar menu (`config/adminlte.php`) with a filter pipeline:
  gate authorization (`can`), href resolution (route/url), automatic
  active-state, and navbar-search normalization. Unlimited treeview nesting,
  badges, icons, section headers.
- Blade layouts: `master` + `page` (extend with `@extends('adminlte::page')`),
  plus navbar, sidebar, footer, color-mode toggle, and user-menu partials.
- Auth views: login, register, forgot-password, reset-password on a dedicated
  auth layout, wired to Laravel's conventional named routes.
- 11 Blade components: card, small-box, info-box, alert, callout, progress,
  input, textarea, select, button, modal. Form components surface validation
  errors and repopulate `old()` input automatically.
- Artisan commands: `adminlte:install` and `adminlte:status`.
- Vite-first asset strategy — pulls `admin-lte` + `bootstrap` from npm and
  imports through the app's Vite pipeline (no precompiled assets shipped).
