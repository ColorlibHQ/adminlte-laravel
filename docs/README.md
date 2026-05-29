# AdminLTE 4 for Laravel — Documentation

Official [AdminLTE 4](https://adminlte.io) integration for Laravel — Bootstrap
5.3, vanilla JS (no jQuery), Vite-ready.

> 📖 These docs are also served **inside your app** at **`/docs`**, rendered with
> the AdminLTE layout. Disable with `'docs' => false` in `config/adminlte.php`.

## Getting started

- [**Installation**](installation.md) — requirements, install, Vite wiring, first page
- [**Configuration**](configuration.md) — every `config/adminlte.php` key
- [**Commands**](commands.md) — `adminlte:install`, `status`, `scaffold`, `make-auth`

## Building your UI

- [**Layout**](layout.md) — `adminlte::page`, navbar, sidebar, footer, ⌘K search, color mode, RTL, preloader
- [**Menu**](menu.md) — config-driven sidebar/navbar menu, treeview, badges, permissions, filters
- [**Components**](components.md) — all 40 Blade components with props, slots, and examples
- [**Plugins**](plugins.md) — lazy-loaded JS libraries (ApexCharts, jsVectorMap, FullCalendar, SortableJS, Flatpickr, Tom Select, Tabulator, Quill)
- [**Translations**](translations.md) — 9 locales and how key resolution works

## Application scaffolding

- [**Scaffolding**](scaffolding.md) — `adminlte:scaffold` generates DB-backed sections (mailbox, chat, kanban, calendar, projects, …)
- [**Authentication**](authentication.md) — `adminlte:make-auth` (plain / Breeze / Fortify)

## Reference

- [**Demo pages**](demo-pages.md) — the bundled showcase routes (Dashboard v2/v3, Widgets, UI Elements, Forms, Tables, …)
- [**Deployment**](deployment.md) — host the full live preview on a server (Nginx + PHP-FPM, public-demo recipe)
- [**Contributing & development**](contributing.md) — local setup, tests, Pint, PHPStan, CI

---

New here? Start with [Installation](installation.md), then skim
[Layout](layout.md) and [Components](components.md).
