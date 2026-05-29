# Layout

AdminLTE 4 for Laravel ships a complete admin shell as Blade views. Your pages
extend the `adminlte::page` layout and fill in a few sections; the package
renders the navbar, sidebar, footer, color-mode toggle, command palette,
control sidebar and preloader around your content.

## Extending the page layout

Most pages extend `adminlte::page`, which is a thin wrapper around
`adminlte::master`:

```blade
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h3 class="mb-0">Dashboard</h3>
@stop

@section('content')
    <p>Welcome to your dashboard.</p>
@stop
```

### Available sections and stacks

| Hook | Type | Purpose |
| --- | --- | --- |
| `@section('title', '...')` | section | Page title. Combined with `title_prefix` / `title_postfix` and falls back to `config('adminlte.title')`. |
| `@section('content_header')` | section | Optional. Rendered inside `.app-content-header` (a `container-fluid`). Omit it entirely to drop the header bar. |
| `@section('content')` | section | Required. Your page body, rendered inside `.app-content > .container-fluid`. |
| `@push('css')` | stack | Per-page `<link>`/`<style>` tags, emitted in `<head>`. |
| `@yield('css')` | section | Same slot as `@push('css')`, for a single block. |
| `@push('js')` | stack | Per-page `<script>` tags, emitted at the end of `<body>`. |
| `@yield('js')` | section | Same slot as `@push('js')`, for a single block. |
| `@push('adminlte_css')` | stack | Early `<head>` CSS, output before the Vite bundle (via the `adminlte_css` section in `page.blade.php`). |

> Scripts are placed at the bottom of `<body>`, after `@pluginScripts`. CSS is
> placed in `<head>`, after the Vite bundle and before `@pluginStyles`.

## Master layout structure

`master.blade.php` builds the document and the body class list from config, then
assembles the shell:

```
<body class="layout-fixed fixed-header ... sidebar-mini bg-body-tertiary">
  preloader
  .app-wrapper
    partials.navbar      (app-header)
    partials.sidebar     (app-sidebar)
    main.app-main
      .app-content-header   (only if content_header section is defined)
      .app-content          (yields content)
    partials.footer      (app-footer)
    partials.control-sidebar
  @pluginScripts
  @stack('js') / @yield('js')
</body>
```

### Body classes driven by config

The `<body>` class list is assembled from these config keys:

| Config key | Class added |
| --- | --- |
| `layout_fixed_sidebar` | `layout-fixed` |
| `layout_fixed_navbar` | `fixed-header` |
| `layout_fixed_footer` | `fixed-footer` |
| `sidebar_breakpoint` (default `lg`) | `sidebar-expand-{breakpoint}` |
| `sidebar_mini` | `sidebar-mini` |
| `sidebar_collapse` | `sidebar-collapse` |
| `classes_body` | appended verbatim |

`bg-body-tertiary` is always added.

The `<html>` element reflects the active locale (`lang`), `dir` (from
`layout_rtl`), and an optional `data-bs-theme="dark"` when a `$darkMode`
variable is set in the view.

## Navbar (`partials/navbar.blade.php`)

The top bar (`.app-header`) has a left and right side.

**Left side:**

- Sidebar toggle (`data-lte-toggle="sidebar"`).
- A **Home** link to `/`.
- A **Documentation** link to `config('adminlte.sidebar_docs_url')`.
- Any items registered for the `navbar-left` menu scope
  (`app('adminlte')->menu('navbar-left')`).

**Right side (`ms-auto`):**

- A unified search pill (`data-adminlte-search`) showing a `⌘K` hint. Clicking
  it (or pressing `⌘K` / `Ctrl+K`) opens the command palette.
- **Messages** dropdown — `partials/navbar-messages.blade.php`.
- **Notifications** dropdown — `partials/navbar-notifications.blade.php`.
- **Fullscreen** toggle (`data-lte-toggle="fullscreen"`).
- **Color-mode** toggle (`partials/color-mode.blade.php`), shown when
  `config('adminlte.color_mode_toggle', true)`.
- **User menu** (`partials/usermenu.blade.php`), shown when
  `config('adminlte.usermenu_enabled', true)`.

The navbar's wrapper classes come from `classes_topnav`
(default `navbar-expand bg-body`) and `classes_topnav_container`
(default `container-fluid`).

### Command palette (⌘K)

`partials/command-palette.blade.php` renders a modal search dialog. It flattens
the sidebar menu into a searchable list of leaf links (skipping headers,
expanding submenus into a breadcrumb-style group label), then filters them
client-side by text or group. Keyboard support: `⌘K`/`Ctrl+K` to toggle,
`↑`/`↓` to move, `Enter` to navigate, `Esc` to close. Styles and script are
emitted inline (`@once` / `@push('js')`) because the partial renders inside the
body.

### Messages & notifications dropdowns

Both are demo-data driven and meant to be replaced with real data in your app:

- **Messages** read `config('adminlte.navbar_messages', [...])` (each item:
  `name`, `text`, `time`, `star`, `img`). The badge shows the message count.
- **Notifications** read `config('adminlte.navbar_notifications', [...])` (each
  item: `icon`, `text`, `time`) and `config('adminlte.navbar_notifications_count')`
  for the badge.

### User menu

`partials/usermenu.blade.php` uses `auth()->user()` for the display name and
avatar (falling back to a bundled placeholder, or the user's
`profile_photo_url` when `usermenu_image` is enabled). The footer links to
`usermenu_profile_url` (default `admin/profile`) and posts to `/logout` for
sign-out.

## Sidebar (`partials/sidebar.blade.php`)

The `.app-sidebar` contains:

- **Brand** — logo image (`logo_img`) and HTML logo text (`logo`,
  default `<b>Admin</b>LTE`), linking to `/`.
- **Treeview menu** — built from `app('adminlte')->menu('sidebar')`, with each
  item rendered by `partials/menu-item.blade.php`. The `<ul>` carries
  `data-lte-toggle="treeview"` (accordion off).
- **"View documentation" CTA** — a bottom button shown only when
  `config('adminlte.sidebar_docs_url')` is set. It collapses to icon-only in a
  mini sidebar and is hidden in a fully-collapsed (non-mini) sidebar.

Sidebar appearance is config-driven: `sidebar_theme` (`dark` adds
`data-bs-theme="dark"`), `classes_sidebar` (default `bg-body-secondary shadow`),
and `classes_sidebar_nav`.

## Footer (`partials/footer.blade.php`)

Config-driven and rendered as raw HTML:

- `config('adminlte.footer_right')` — right side (default `Version <b>4.0</b>`),
  hidden on extra-small screens.
- `config('adminlte.footer_left')` — left side.

## Color mode (light / dark / auto)

The color-mode dropdown offers **Light**, **Dark** and **Auto** (system
preference). The selection is wired by the core `adminlte.js` (published from
`resources/js/adminlte.js`) using `data-bs-theme-value` buttons and
`data-lte-theme-icon` icons. **Auto** is the default active option.

## RTL

Set `config('adminlte.layout_rtl', true)`. The master layout then sets
`dir="rtl"` on `<html>` and loads the prebuilt RTL stylesheet from
`vendor/adminlte/css/adminlte.rtl.min.css`. That file is copied into
`public/vendor` by `php artisan adminlte:install` (see the plugins doc).

## Preloader

`partials/preloader.blade.php` renders a centered animated logo only when
`config('adminlte.preloader', false)` is enabled. It uses the bundled
`vendor/adminlte/img/AdminLTELogo.png`.

## Control sidebar

`partials/control-sidebar.blade.php` renders a right-hand `.control-sidebar`
only when `config('adminlte.control_sidebar', false)` is enabled. Its theme
comes from `control_sidebar_theme` (default `dark`) and it exposes a `$slot` for
custom content. Toggle it with `data-lte-toggle="control-sidebar"`.

## Plugin asset directives

The master layout includes two directives that run at **request time** (not
compile time), so plugins enabled by components on the current page are
reflected:

- `@pluginStyles` — in `<head>`, emits `<link>` tags for every enabled plugin's
  CSS.
- `@pluginScripts` — at the bottom of `<body>`, emits `<script>` tags for every
  enabled plugin's JS.

See [plugins.md](plugins.md) for details.

## Minimal page example

```blade
@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
    <h3 class="mb-0">Reports</h3>
@stop

@section('content')
    <x-adminlte-card title="Monthly summary">
        <p>Your content here.</p>
    </x-adminlte-card>
@stop

@push('css')
    <style>.report-table th { white-space: nowrap; }</style>
@endpush

@push('js')
    <script>console.log('Reports page ready');</script>
@endpush
```
