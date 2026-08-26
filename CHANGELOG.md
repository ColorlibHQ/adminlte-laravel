# Changelog

All notable changes to `colorlibhq/adminlte-laravel` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.5.0] - 2026-08-26

### Added

- `ColorlibHQ\AdminLte\Support\UserTable` — resolves the table backing the app's
  users (an authenticated Eloquent user answers for itself; otherwise the default
  guard's provider config, `table` for the `database` driver or the `model` it
  names for `eloquent`; `users` as the fallback). Package code and the console
  commands both ask it rather than hardcoding the conventional name.
- `ColorlibHQ\AdminLte\Console\Concerns\RendersStubs` — the placeholder
  substitution `adminlte:scaffold` and `adminlte:make-auth` run over every stub
  they publish. Stubs write `{{ users_table }}`; the resolved name is baked into
  the published file, so generated migrations name their table outright instead
  of consulting config at run time.

### Fixed

- The navbar message dropdown no longer assumes the user table is called
  `users` with an `id` key. `NavbarData::messages()` now resolves the table from
  the authenticated user (an Eloquent model answers for itself; the `database`
  provider's `GenericUser` is read off `auth.providers.*.table`, falling back to
  `users`) and joins on `getAuthIdentifierName()` instead of a hardcoded
  `u.id`. Apps with a renamed users table or a custom auth model previously got
  a "no such table: users" error on every authenticated page render.
  Thanks [@ruanpepe](https://github.com/ruanpepe) for reporting and for the
  original patch (#17).
- `adminlte:scaffold` and `adminlte:make-auth` no longer publish code that
  hardcodes the `users` table (#18). Seven migrations used
  `constrained('users')`, so `php artisan migrate` failed outright on an app
  that had renamed it; `DashboardController`, `ChatController`, the profile
  migration, `StoreMessageRequest`, `UpdateProfileRequest`, the RBAC
  `UserController`, `RegisterController`, and the published `ProfileTest` all
  named the table or `users.id` in queries and validation rules. Every one now
  goes through the placeholder. Output for an app on the conventional `users`
  table is byte-for-byte what it was.

  The primary key is deliberately untouched: the scaffold's `foreignId()`
  columns presume a `bigint` `id`, so a user model on a UUID key still needs
  those foreign keys adjusted by hand. This is now stated in
  [`docs/scaffolding.md`](docs/scaffolding.md).

## [1.4.0] - 2026-08-19

### Changed

- Bumped the AdminLTE version advertised by `adminlte:install` (and the matching
  README/docs) to the current latest: `admin-lte@^4.8` (was `^4.3`). No other
  advertised package moved. Verified against the published 4.8.1 tarball that
  every path this package consumes still exists —
  `admin-lte/dist/css/adminlte.css`, `admin-lte/dist/css/adminlte.rtl.min.css`
  (vendor-copied by the installer) and `admin-lte/src/scss/adminlte` (the
  Option B source build in the published CSS stub) — and that the `--bs-*`
  custom properties the theme colors override are untouched.

  What the core releases in that range bring to an app on this package:

  - **4.4.0** — opt-in extended palette (`admin-lte/dist/css/adminlte-colors.css`,
    14 colours plus sidebar/navbar skins) and a fix that lets `.sidebar-wrapper`
    fill the sidebar. The package's `partials/sidebar.blade.php` uses that class,
    so the fix applies with no change here.
  - **4.5.0** — `admin-lte/dist/css/adminlte-colors-v3.css`, the 18 AdminLTE 3
    colours exactly as they were, for apps ported from v3.
  - **4.6.0** — `data-lte-primary="teal"` on `<html>` promotes any palette colour
    to Bootstrap's `primary` (buttons, links, pagination, form focus rings).
  - **4.7.0** — `data-lte-print="plain"` for pages meant to print as documents.
  - **4.8.0** — `data-lte-contrast="aa"` for WCAG AA text on the v3 palette.
  - **4.8.1** — pagination focus-ring fix.

  Both palette stylesheets are opt-in and additive: add the one you want to
  `resources/css/adminlte.css` next to the existing `admin-lte/dist/css/adminlte.css`
  import. The `data-lte-*` attributes go on `<html>`, which this package renders in
  `resources/views/master.blade.php` (and `auth/auth-master.blade.php`,
  `layouts/errors-master.blade.php`). Nothing is enabled by default, so an
  install that changes nothing looks exactly as it did.

### Fixed

- **Navbar documentation link now respects `sidebar_docs_url` config.** When
  `sidebar_docs_url` is set to `false` to hide the documentation CTA in the
  sidebar, the documentation link in the navbar is now also hidden, making
  behaviour consistent across both locations.

## [1.3.1] - 2026-08-13

### Fixed

- Documentation: `usermenu_profile_url` was documented as taking `'profile'`
  after scaffolding. `adminlte:scaffold` registers its routes in a group
  prefixed `admin`, so the correct value is `'admin/profile'`. The 1.3.0 notes
  also claimed nothing in the package served `/admin/profile`; that was wrong.
  Hiding the link when the key is `false` — the actual behaviour change — is
  unaffected and still matches what the docs have always said.

## [1.3.0] - 2026-08-13

Three config blocks that have shipped since 1.0 — `auth_logo` and the six
`usermenu_*` keys — were never read by any view, and the lockscreen rendered
against class names AdminLTE 4 does not define. All of it now works.

**Upgrading:** the `usermenu_*` keys default to `false`, so honouring them
hides the user dropdown's coloured header, its avatar and its Profile button
on apps that were relying on the hardcoded markup. Set `usermenu_header`,
`usermenu_image` and `usermenu_desc` to `true` — and `usermenu_profile_url` to
a path — to keep the previous appearance.

### Added

- `ColorlibHQ\AdminLte\Http\Middleware\DemoUserMenu`, applied to the bundled
  demo route group. It turns the user-menu header, avatar and description on
  for `demo/*` requests only, so the showcase keeps the full AdminLTE dropdown
  while a fresh install still gets the plain one. See `docs/demo-pages.md`.

### Fixed

- **`auth_logo` is wired up.** The config block has shipped since 1.0 but no
  view ever read it, so enabling it did nothing. The auth pages now render the
  configured image — honouring `class`, `width` and `height`, and omitting each
  attribute when its config value is empty — above the text `logo`. With
  `auth_logo.enabled` left at its `false` default the auth pages are unchanged.
- **The user-menu config keys did nothing.** `usermenu_header`,
  `usermenu_header_class`, `usermenu_image` and `usermenu_desc` have shipped
  since 1.0 but the partial ignored all four and hardcoded the header, the
  avatar and the "member since" line. They are now honoured. Note the defaults
  are all `false`, so the dropdown header is hidden unless you turn it on —
  set `usermenu_header` and `usermenu_image` to `true` to keep the previous
  appearance. The bundled demo pages do exactly that for themselves via the new
  `DemoUserMenu` middleware, so the showcase keeps the coloured header and the
  90px avatar without changing what a fresh install ships.
  `usermenu_header_class` default corrected to `text-bg-primary`; `bg-primary`
  alone sets no contrasting foreground color.
- **`usermenu_profile_url => false` now hides the "Profile" link** as the docs
  have always claimed, instead of silently falling back to `/admin/profile`.
  With the link hidden, "Sign out" fills the footer. To keep the link, set the
  key to `'admin/profile'` — the path `adminlte:scaffold profile` creates.
- **The lockscreen rendered unstyled.** It extended the auth card layout, which
  produced `.lockscreen-page` / `.lockscreen-box` — neither exists in AdminLTE
  4. The page's real styles are all scoped under a `.lockscreen` body class, so
  none of them applied. It is now a standalone layout carrying that class, and
  posts to the `password.confirm` route (falling back to the bare path when
  auth hasn't been scaffolded) instead of to `login`, which could never have
  succeeded from a password-only form. Reported by
  [@ruanpepe](https://github.com/ruanpepe).

## [1.2.0] - 2026-08-11

### Added

- **Theme colors are now real config keys.** `primary_color`, `sidebar_color`,
  `navbar_color` and `footer_color` repaint the chrome without compiling SCSS.
  Each is injected into the layout `<head>` as a block of CSS custom-property
  overrides by the new `ColorlibHQ\AdminLte\Support\ThemeColors`; all four
  default to `null`, in which case nothing is emitted and the stock AdminLTE
  palette applies untouched. `primary_color` also recomputes the hover/active
  button shades with Bootstrap's `shade-color()` weights and picks button text
  the way Bootstrap's `color-contrast()` does, so a custom brand color behaves
  like a recompiled `$primary` instead of a flat swap. Values are validated
  against a strict `#rgb`/`#rrggbb` pattern and anything else is dropped — the
  block is rendered unescaped, so only hex is safe to put in it. Applies to the
  main, auth and error layouts. See `docs/configuration.md`.

### Changed

- **The control sidebar is now a Bootstrap Offcanvas, and actually works.** It
  was rendering AdminLTE 3 markup: `.control-sidebar` / `.control-sidebar-dark`
  / `.control-sidebar-content` plus `data-lte-toggle="control-sidebar"`. AdminLTE
  4 dropped that component — the string does not appear anywhere in 4.1 or 4.3,
  in the CSS, the JS or the SCSS source — so there were no styles, no toggle
  handler, and no grid area for a right-hand panel. Setting
  `control_sidebar => true` did not give you a panel that failed to open; it
  injected an unstyled, permanently visible block into the layout grid after the
  footer, and nothing in the package could open or close it.

  It is now a Bootstrap Offcanvas (`#adminlte-control-sidebar`), which brings the
  backdrop, Esc-to-close and focus trap for free and needs no custom CSS or JS —
  Bootstrap is already imported by the published `resources/js/adminlte.js`.
  Enabling `control_sidebar` also adds the gear toggle to the navbar that was
  missing, so the panel can be opened at all. `control_sidebar_theme` now does
  something too: it is applied as `data-bs-theme` on the panel. Fill the body
  with `@section('control_sidebar')` or `@push('control_sidebar')`; the `$slot`
  path still works for direct includes.

  **If you styled the old class names yourself, retarget those rules at
  `#adminlte-control-sidebar`.** In practice nothing rendered before, so this is
  unlikely to affect anyone.
- Bumped the frontend dependency versions advertised by `adminlte:install`
  (and the matching README/docs) to the current latest: `admin-lte@^4.3`
  (was `^4.1`) and `apexcharts@^6.8` (was `^6.7`). Every other advertised
  package was already at its current minor. `fullcalendar` stays at `^6.1` for
  the reason recorded in `InstallCommand`: v7 drops the minified global bundle
  this package copies and swaps the bundled CSS for a skeleton + theme + palette
  model. Verified against the published tarballs that every vendor-copied source
  path still exists at the versions these ranges now resolve to, and that the
  `--bs-*` custom properties the theme colors override are unchanged between
  admin-lte 4.1.0 and 4.3.1. Dev: `orchestra/testbench` `^11.2`,
  `larastan/larastan` `^3.10`.

### Fixed

- **Every color picker on the Theme Generator demo rendered Bootstrap blue.**
  The page passed `value="#343a40"` to `<x-adminlte-input-color>`, which has no
  `value` prop — so the color fell through to `$attributes->merge()` and was
  appended *after* the component's own `value`, and browsers keep the first of
  two duplicate attributes. All four swatches showed `#0d6efd` regardless of
  what the page asked for. They now use the documented `default` prop and are
  seeded from config. Reported and originally fixed by
  [@ruanpepe](https://github.com/ruanpepe) in
  [#8](https://github.com/ColorlibHQ/adminlte-laravel/pull/8).
- **The Theme Generator emitted a config snippet that did nothing.** Four of the
  five keys it told you to paste were never read by the package, and `color_mode`
  was not a config key at all. It now writes only keys that exist, previews every
  change live on the page, seeds each control from the running config, and labels
  the color-mode select as preview-only (the runtime mode comes from the topbar
  toggle and the visitor's system preference).
- Color inputs on the Theme Generator now use the component's `label` prop, so
  each label is actually associated with its input instead of floating loose.

## [1.1.0] - 2026-08-06

### Fixed

- **Flatpickr, Tom Select, Tabulator and Quill never worked.** All four
  optional plugins were broken end to end, so `<x-adminlte-editor>`,
  `<x-adminlte-input-flatpickr>`, `<x-adminlte-input-tom-select>` and
  `<x-adminlte-datatable>` rendered inert markup no matter how the app was
  set up. Two independent gaps, both fixed:
  - `adminlte:install` never copied the four libraries out of `node_modules`,
    even though `config('adminlte.plugins')` pointed at
    `public/vendor/{quill,flatpickr,tom-select,tabulator-tables}/…`. Every
    `@pluginScripts` tag they emitted 404'd. They're now in the installer's
    copy map, and `InstallCommandTest` asserts that every configured plugin
    asset has a matching copy source so this can't regress.
  - The published `resources/js/adminlte.js` had no initializer for any of
    them, so even a hand-copied library did nothing. It now ships
    `initDatePickers()`, `initTomSelects()`, `initDatatables()` and
    `initEditors()` alongside the existing four, each feature-detecting its
    global and skipping elements it has already wired.

  Quill in particular now seeds itself from the component's hidden input,
  mirrors its HTML back on every change so a plain form POST submits the
  content, and writes `''` instead of `<p><br></p>` when emptied so
  `required` / `nullable` validation behaves.
  ([#6](https://github.com/ColorlibHQ/adminlte-laravel/issues/6))
- `adminlte:install` now copies vendor files on `--only=assets`, and after a
  declined npm prompt or `--no-interaction-deps`. Previously the copy step
  ran only on a full interactive install where the prompt was accepted, so
  anyone managing npm themselves silently got an empty `public/vendor`.
  Re-running `adminlte:install --only=assets` is now the documented way to
  pick up a plugin installed after the initial setup.

### Changed

- `adminlte:status` groups its output into **Required**, **Optional** and
  **Optional plugins**, and lists the four optional plugin libraries so a
  half-finished install is visible. Opt-in resources (published views,
  scaffolded sections) no longer render as a red ✗ that triggers a
  "resources are missing" warning — they were never part of a default
  install, and the warning sent people to re-run a command that wouldn't
  have created them.
- Bumped the frontend dependency versions advertised by `adminlte:install`
  (and the matching README/docs) to the current latest: `apexcharts@^6.7`
  (was `^5.16`) and `sass@^1.102`. `fullcalendar` stays at `^6.1`: v7 drops
  the minified global bundle entirely (`index.global.min.js` is gone in
  favour of an unminified `all/global.js`) and replaces the bundled CSS with
  a `skeleton.css` + theme + palette model, which the calendar component
  needs explicit work to support.
- `laravel/pint` dev constraint raised to `^1.30`.

## [1.0.2] - 2026-07-09

### Fixed

- `adminlte:install` CSS stub now imports OverlayScrollbars via the
  export-safe `overlayscrollbars/overlayscrollbars.css` specifier. The old
  `overlayscrollbars/styles/overlayscrollbars.css` path is absent from the
  package's `exports` map before 2.5.0, so Vite/PostCSS failed on installs
  resolving to overlayscrollbars 2.0–2.4 (`Missing "./styles/…" specifier`).
  The short specifier resolves across the whole 2.x range.
  ([#3](https://github.com/ColorlibHQ/adminlte-laravel/issues/3))

### Changed

- Bumped the frontend dependency versions advertised by `adminlte:install`
  (and the matching README/docs) to the current latest: `admin-lte@^4.1`,
  `overlayscrollbars@^2.16`, `apexcharts@^5.16`, `sass@^1.101`,
  `tom-select@^2.6`, `tabulator-tables@^6.5`. `fullcalendar` stays at
  `^6.1` — v7 drops the bundled CSS and Bootstrap 5 theme the calendar
  component relies on. No `composer.json` changes: every PHP constraint
  already allows the current major (verified green against Laravel 13.19,
  PHPUnit 13.2.4, Pint 1.29.3, Larastan 3.10).
- CI: `actions/checkout` upgraded v6 → v7.
  ([#2](https://github.com/ColorlibHQ/adminlte-laravel/pull/2))

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
