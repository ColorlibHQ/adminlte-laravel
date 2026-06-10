# Changelog

All notable changes to `colorlibhq/adminlte-laravel` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.1] - 2026-06-10

### Fixed

- Dev tooling only — nothing changes for consuming apps:
  - `phpunit/phpunit` constraint widened to `^12.4 || ^13.0` (PHPUnit 13
    requires PHP ≥ 8.4.1, which made `composer update` unresolvable for
    contributors and CI on PHP 8.3).
  - PHPStan: ignore the always-false `class_exists('App\…')` finding the
    latest release reports for the service provider's intentional
    consuming-app guards.

## [1.0.0] - 2026-06-10

First stable release. The package now offers full AdminLTE 4 demo parity,
40 Blade components, an 18-section scaffolding system, dependency-free RBAC,
9 complete locales, in-app docs, and a 57-test suite — Pint, PHPStan level 8
and PHPUnit run green on PHP 8.3–8.5 / Laravel 13.

### Added — Authorization (RBAC)

- **Native, dependency-free RBAC** via `adminlte:scaffold rbac`: roles &
  permissions tables, `Role`/`Permission` models, a `HasRoles` trait wired into
  the `User` model (idempotent), `role:`/`permission:` middleware, a seeder
  (admin/editor/viewer), and a **Users/Roles management UI** under `/admin`.
- The service provider opportunistically wires it when present (guarded by
  `class_exists`): registers the scaffolded model policies, aliases the
  `role`/`permission` middleware, and adds a permission-aware `Gate::before`
  (admins pass everything; otherwise abilities resolve against permissions, so
  `@can('manage-x')` and menu `'can' => 'manage-x'` just work).
- An **ADMINISTRATION** sidebar section (Users, Roles), gated by `can`.

### Added — Deep Laravel integration per scaffolded section

- DB-backed sections now also generate **model factories** (`HasFactory`),
  **Form Requests** (validated writes), **Policies** (controllers call
  `authorize()`), and **feature tests** in `tests/Feature/AdminLte/`.

### Added — Dashboard, notifications, account, audit, API, real-time

- **Data-driven dashboard** (`adminlte:scaffold dashboard`): a
  `DashboardController` + view rendering real aggregates (users, projects,
  unread messages, upcoming events, projects-by-status, recent activity), each
  guarded by table existence.
- **Notifications** (`adminlte:scaffold notifications`): standard Laravel
  database notifications, a notifications page, and a `NavbarData` helper that
  feeds the navbar **bell** and **messages** dropdowns from real data (unread
  notifications / unread mailbox messages) with graceful fallback to demo data.
- **Account management** — the `profile` scaffold is now a tabbed account page:
  avatar upload, change password, active sessions + log-out-other-devices, and
  delete account.
- **Impersonation** (`adminlte:scaffold impersonation`): RBAC-gated "log in as"
  from the Users table, a revert banner on every page, and audit logging.
- **Activity/audit log** (`adminlte:scaffold activity-log`): an `activity_log`
  table, `Activity` model, a `LogsActivity` model trait, a viewer, and
  **automatic auth-event logging** (login/logout/failed) via the service
  provider — all through `ColorlibHQ\AdminLte\Support\ActivityLogger`.
- **API tokens** (`adminlte:scaffold api`): a Sanctum personal-access-token
  management UI, `HasApiTokens` wired into `User` (`trait_exists`-guarded), and
  an example `auth:sanctum` endpoint. Requires `php artisan install:api`.
- **Real-time** (`adminlte:scaffold realtime`): a `NewChatMessage` broadcast
  event, conversation channel authorization, and an Echo listener bundle for
  live chat & notifications. Degrades gracefully without a broadcaster.

### Added — Auth hardening (`adminlte:make-auth`, plain mode)

- Login **rate limiting** (5 attempts per email+IP), **email verification**
  (controller, view, signed/throttled routes; `User` made to implement
  `MustVerifyEmail`), and **password confirmation** (controller, view,
  `password.confirm` route).

### Added — Documentation

- New guides: `authorization`, `account-management`, `notifications`,
  `activity-log`, `dashboard`, `api`, `realtime`, and `deployment` — all
  registered in the in-app docs nav and the `docs/` index, and cross-linked
  from `scaffolding.md`.

### Added — Polish pass (i18n, a11y, DX)

- **All 9 locales are now complete.** Backfilled the missing keys (33 in
  `de`/`es`, 76 in `fr`/`it`/`ja`/`pt_BR`/`ru`/`zh`) covering account
  management, email verification, sessions, impersonation, API tokens,
  activity log, navbar, and the RBAC UI.
- `AdminLte::add()` — append menu items at runtime; and `addAfter()` now
  really splices items after the item whose `key`/`text`/`header` matches
  (it previously appended to the end regardless of the key).
- Accessibility: decorative icons are `aria-hidden`; form components link
  validation errors via `aria-describedby`/`aria-invalid`; sidebar submenu
  toggles expose `aria-expanded` (kept in sync by the published `app.js`);
  the command palette is a proper `combobox`/`listbox` with
  `aria-activedescendant`.
- Composer scripts: `composer test` / `lint` / `fix` / `analyse` / `check`
  (`analyse` bakes in the `--memory-limit=1G` PHPStan now needs). CI uses
  them and also runs on PHP 8.5.
- Community files: issue/PR templates, `SECURITY.md`, Dependabot config.
- 23 new tests: runtime menu mutations, docs routes (incl. traversal
  attempts), component escaping/XSS regressions, `NavbarData` fallbacks.

### Changed

- `adminlte:install` pins every npm dependency to a tested major version
  (notably `fullcalendar@^6.1` — v7 is breaking) and prints install guidance
  for the optional plugins (Flatpickr, Tom Select, Tabulator, Quill).
- Auth and error layouts no longer load Bootstrap Icons from the jsDelivr
  CDN — the icons already ship in the Vite bundle (`resources/css/adminlte.css`),
  so offline/strict-CSP apps work and the double-load is gone.
- The command palette builds its result list with `textContent` instead of
  HTML string concatenation.

### Fixed

- `NavbarData::notifications()`/`messages()` now respect the `$limit`
  argument for demo/fallback data too.
- Profile Card social links reject dangerous URL schemes (`javascript:`,
  `data:`) — only `http(s)`, `mailto` and relative URLs render.
- Docs route asserts the resolved file stays inside `docs/` (defense in
  depth on top of the existing slug sanitization).
- ApexCharts init in the published `app.js` is wrapped in try/catch so one
  bad chart config can't break every chart on the page.
- Removed three duplicate keys (`email`, `profile`, `no_messages`) from the
  `de`/`es` translation files.
- Sanctum/RBAC trait detection uses `trait_exists` (traits are not classes).
- `create_activity_log_table` / `create_notifications_table` migrations are
  guarded against re-runs.

### Quality

- Pint clean; PHPStan level 8 clean; 32 package tests pass (added
  `MakeAuthCommandTest`; extended `ScaffoldCommandTest` for the new artifact
  types — notifications, concerns, events — and view-less sections).

## [0.8.0] - 2026-05-29

### Added (Full 1:1 parity with the AdminLTE 4 demo)

- **Faithful Dashboard v1** recreation behind Laravel auth — small-boxes,
  Sales Value ApexCharts area chart, jsVectorMap world map with sparklines,
  and Direct Chat, matching `index.html`.
- **Showcase pages** wired to the sidebar (every link now resolves):
  Dashboard v2 & v3, Widgets (Small Box / Info Box / Cards), UI Elements
  (General / Icons / Timeline), Forms (Elements / Layout / Validation /
  Wizard), Tables (Simple / Data), and a config-driven Layout Options page.
- **⌘K command palette** — a floating overlay that searches the sidebar menu;
  opens via the navbar search pill or Cmd/Ctrl+K, with arrow-key navigation.
- **Demo routes** auto-registered by the service provider behind
  `config('adminlte.demo')` (default `true`) and `demo_middleware`
  (default `['web', 'auth']`); set `'demo' => false` to skip them.
- Navbar messages & notifications dropdowns, and a richer user menu, bound to
  the authenticated user; "View documentation" CTA in the sidebar
  (`sidebar_docs_url`).
- Comprehensive documentation under [`docs/`](docs/): installation,
  configuration, layout, menu, components, plugins, scaffolding,
  authentication, commands, translations, and demo pages.
- **In-app documentation viewer** — the `docs/*.md` files are rendered (via
  CommonMark) inside the AdminLTE layout at `/docs` and `/docs/{page}`, with a
  navigation sidebar and intra-doc links rewritten to `/docs/…`. Toggle with
  `config('adminlte.docs')` / `docs_middleware`. The navbar "Documentation"
  link and sidebar CTA point here by default (`sidebar_docs_url`).

### Changed

- Scaffolded page designs upgraded to match the originals while keeping their
  DB backing: **Profile** (About card + Activity/Timeline/Settings tabs),
  **Invoice** (print-ready with subtotal/tax/total), **Chat** (split-pane with
  styled bubbles), **Settings** (multi-section), **Calendar** (draggable-events
  sidebar), **File Manager** (folder breadcrumb + file-type grid).
- Footer text reduced to a compact, regular-weight line (config-driven via
  `footer_left` / `footer_right`).

### Fixed

- **Translations**: `__('adminlte.key')` now resolves out of the box — the
  package registers its lang directory as a default-namespace path. Previously
  every key (navbar, sidebar, auth views) rendered as a raw `adminlte.*`
  string because translations were only registered under the `adminlte::`
  namespace.
- **Navbar search** now works — replaced the inert AdminLTE 3
  `data-widget="navbar-search"` hook with the ⌘K command palette.
- The sidebar "View documentation" CTA collapses to an icon-only button when
  the sidebar is minimised (and hides on fully-collapsed off-canvas sidebars).
- `@pluginStyles` / `@pluginScripts` resolve enabled plugins at **request
  time** instead of compile time, so component-enabled plugins are injected.
- Removed the duplicate CDN Bootstrap Icons `<link>` (icons now come solely
  from the Vite bundle).
- `adminlte:install` installs the plugin npm packages (apexcharts, jsvectormap,
  fullcalendar, sortablejs) and copies their dist files (plus the RTL
  stylesheet) into `public/vendor/*`, fixing 404s that left charts/maps/
  calendar/kanban blank.
- `app.js` initialises ApexCharts, jsVectorMap, FullCalendar, and SortableJS
  from the `data-*` attributes the components emit.
- Tabs/Tab panes push to a Blade stack so they render inside `.tab-content`.

### Quality

- PHPStan level 8 fully clean (0 errors) across `src/`; Pint clean; 26 tests
  pass. Stopped tracking the PHPStan cache (`/build`).

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
