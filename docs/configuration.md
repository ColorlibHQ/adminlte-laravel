# Configuration

All configuration lives in `config/adminlte.php`. After running
`php artisan adminlte:install` the file is published to your application's
`config/adminlte.php`, where you can edit any of the keys below.

Every key documented here reflects the actual published config file. Defaults
are the values shipped with the package.

---

## Title & Branding

| Key | Default | Description |
| --- | --- | --- |
| `title` | `'AdminLTE 4'` | Default page title used when no `@section('title')` is set. |
| `title_prefix` | `''` | String prepended to every page title. |
| `title_postfix` | `''` | String appended to every page title. |

### Logo

| Key | Default | Description |
| --- | --- | --- |
| `logo` | `'<b>Admin</b>LTE'` | Brand text shown in the sidebar header (accepts HTML). |
| `logo_img` | `'vendor/adminlte/img/AdminLTELogo.png'` | Path to the brand logo image. |
| `logo_img_class` | `'brand-image opacity-75 shadow'` | CSS classes applied to the logo image. |
| `logo_img_alt` | `'AdminLTE Logo'` | `alt` text for the logo image. |

> **Security note:** `logo` is rendered unescaped (`{!! !!}`) so it can hold
> markup like `<b>Admin</b>LTE`. Only put trusted, hardcoded markup here —
> never user-supplied or database-driven content.

### Authentication Logo

| Key | Default | Description |
| --- | --- | --- |
| `auth_logo.enabled` | `false` | Show a logo on the auth (login/register) pages. |
| `auth_logo.img.path` | `'vendor/adminlte/img/AdminLTELogo.png'` | Path to the auth-page logo image. |
| `auth_logo.img.alt` | `'Auth Logo'` | `alt` text for the auth logo. |
| `auth_logo.img.class` | `''` | CSS classes for the auth logo image. |
| `auth_logo.img.width` | `50` | Auth logo width in pixels. |
| `auth_logo.img.height` | `50` | Auth logo height in pixels. |

### Favicon

| Key | Default | Description |
| --- | --- | --- |
| `use_ico_only` | `false` | Use only a `favicon.ico` instead of the full favicon set. |
| `use_full_favicon` | `false` | Emit the complete favicon link set (apple-touch, sizes, manifest, etc.). |

### Google Fonts

| Key | Default | Description |
| --- | --- | --- |
| `google_fonts.allowed` | `true` | Load Source Sans 3 from Google Fonts. Set `false` to self-host or skip. |

---

## Layout Toggles

Body-level switches that map directly to AdminLTE 4 body classes. A value of
`null` means "leave the class off / inherit default behavior".

| Key | Default | Body class | Description |
| --- | --- | --- | --- |
| `layout_topnav` | `null` | `.layout-top-nav` | Render a top-navigation layout (no sidebar). |
| `layout_boxed` | `null` | `.layout-boxed` | Constrain the layout to a boxed, centered width. |
| `layout_fixed_sidebar` | `true` | `.layout-fixed` | Keep the sidebar fixed while content scrolls. |
| `layout_fixed_navbar` | `true` | `.fixed-header` | Keep the top navbar fixed at the top. |
| `layout_fixed_footer` | `null` | `.fixed-footer` | Keep the footer fixed at the bottom. |
| `layout_dark_mode` | `null` | — | Force dark mode. `null` respects the system / user toggle. |
| `layout_rtl` | `false` | — | Enable right-to-left (RTL) layout. |

### Custom Body / Element Classes

| Key | Default | Description |
| --- | --- | --- |
| `classes_body` | `''` | Extra classes on `<body>`. |
| `classes_brand` | `''` | Extra classes on the brand/logo link. |
| `classes_brand_text` | `'fw-light'` | Extra classes on the brand text. |
| `classes_content_wrapper` | `''` | Extra classes on the content wrapper. |
| `classes_content_header` | `''` | Extra classes on the content header. |
| `classes_content` | `''` | Extra classes on the main content area. |
| `classes_sidebar` | `'bg-body-secondary shadow'` | Extra classes on the sidebar element. |
| `classes_sidebar_nav` | `''` | Extra classes on the sidebar `<nav>`. |
| `classes_topnav` | `'navbar-expand bg-body'` | Extra classes on the top navbar. |
| `classes_topnav_nav` | `'navbar'` | Extra classes on the top navbar `<nav>`. |
| `classes_topnav_container` | `'container-fluid'` | Container class for the top navbar. |

---

## Sidebar

| Key | Default | Description |
| --- | --- | --- |
| `sidebar_breakpoint` | `'lg'` | Breakpoint at which the sidebar expands (`sidebar-expand-{breakpoint}`). |
| `sidebar_mini` | `true` | Enable the collapsible mini sidebar (`.sidebar-mini`). |
| `sidebar_collapse` | `false` | Start with the sidebar collapsed. |
| `sidebar_collapse_auto_size` | `false` | Auto-size the collapsed sidebar. |
| `sidebar_scrollbar_theme` | `'os-theme-light'` | OverlayScrollbars theme for the sidebar. |
| `sidebar_scrollbar_auto_hide` | `'leave'` | When to auto-hide the sidebar scrollbar (`leave`, `never`, etc.). |
| `sidebar_theme` | `'dark'` | Sidebar color theme: `'dark'` or `'light'` (uses `data-bs-theme`). |
| `sidebar_docs_url` | `'https://adminlte.io/themes/v4/docs/introduction.html'` | URL for the "View documentation" CTA button at the bottom of the sidebar. Set `false` to hide it. |

---

## Color Mode

| Key | Default | Description |
| --- | --- | --- |
| `color_mode_toggle` | `true` | Show the Light / Dark / Auto color-mode dropdown in the topbar. |

> Related: `layout_dark_mode` (Layout section) and `sidebar_theme` (Sidebar
> section) also affect appearance.

---

## User Menu (Topbar Dropdown)

| Key | Default | Description |
| --- | --- | --- |
| `usermenu_enabled` | `true` | Show the user dropdown menu in the topbar. |
| `usermenu_header` | `false` | Show a colored header block inside the user dropdown. |
| `usermenu_header_class` | `'bg-primary'` | Background class for the user dropdown header. |
| `usermenu_image` | `false` | Show the user's avatar in the dropdown. |
| `usermenu_desc` | `false` | Show a description/subtitle under the user's name. |
| `usermenu_profile_url` | `false` | URL for the dropdown's "Profile" link (false to hide). |

---

## Footer & Preloader

| Key | Default | Description |
| --- | --- | --- |
| `footer_left` | Copyright string with `AdminLTE.io` link | HTML shown on the left side of the footer. |
| `footer_right` | `'Anything you want'` | HTML shown on the right side of the footer. |
| `preloader` | `false` | Show a full-page preloader on load. |

> **Security note:** `footer_left` / `footer_right` are rendered unescaped
> (`{!! !!}`) so they can hold links and markup. Only put trusted, hardcoded
> markup here — never user-supplied or database-driven content.
| `control_sidebar` | `false` | Enable the right-hand control sidebar panel. |
| `control_sidebar_theme` | `'dark'` | Theme for the control sidebar (`'dark'` or `'light'`). |

---

## Search / Command Palette

The package does not expose a dedicated top-level search config block. A search
box is instead added as a **menu item** of type `navbar-search`, normalized by
`SearchFilter`:

```php
'menu' => [
    [
        'type'        => 'navbar-search',
        'method'      => 'get',      // defaults to 'get'
        'placeholder' => 'Search',   // defaults to 'Search'
        'url'         => 'search',    // defaults to '#'
        'topnav_right' => true,       // place it in the right topbar
    ],
],
```

See [menu.md](menu.md) for the full menu item reference.

---

## Demo / Showcase Pages

| Key | Default | Description |
| --- | --- | --- |
| `demo` | `true` | When `true`, registers the bundled showcase routes (Dashboard v2/v3, Widgets, UI Elements, Forms, Tables, Layout Options, Theme Generator, auth variants, error pages). Set `false` to skip registering these routes in production. |
| `demo_middleware` | `['web', 'auth']` | Middleware applied to the demo routes when `demo` is enabled. |

---

## Plugins

Optional JavaScript libraries integrated with AdminLTE 4. Each entry is disabled
by default; enable only the plugins you use to avoid loading unnecessary assets.
Assets are injected via the `@pluginStyles` and `@pluginScripts` Blade
directives, and are loaded lazily when a component requires them.

Each plugin supports `enabled` (bool), `css` (string path, optional), and `js`
(string path or array of paths).

| Plugin | `enabled` | `css` | `js` |
| --- | --- | --- | --- |
| `flatpickr` | `false` | `vendor/flatpickr/flatpickr.min.css` | `vendor/flatpickr/flatpickr.min.js` |
| `tom_select` | `false` | `vendor/tom-select/tom-select.bootstrap5.min.css` | `vendor/tom-select/tom-select.complete.min.js` |
| `tabulator` | `false` | `vendor/tabulator-tables/tabulator.min.css` | `vendor/tabulator-tables/tabulator.min.js` |
| `quill` | `false` | `vendor/quill/quill.snow.css` | `vendor/quill/quill.min.js` |
| `apexcharts` | `false` | — | `vendor/apexcharts/apexcharts.min.js` |
| `jsvectormap` | `false` | `vendor/jsvectormap/jsvectormap.min.css` | `vendor/jsvectormap/jsvectormap.min.js` + `vendor/jsvectormap/maps/world.js` |
| `fullcalendar` | `false` | — | `vendor/fullcalendar/index.global.min.js` |
| `sortablejs` | `false` | — | `vendor/sortablejs/sortablejs.min.js` |

> `jsvectormap` lists two JS files: the library first, then the world-map data
> (which registers the `'world'` map).

---

## Menu Filters

The `filters` array lists the filter classes applied to every menu item before
rendering, **in order**. Each class implements
`ColorlibHQ\AdminLte\Menu\Filters\FilterInterface`. You can add your own filters
to this array.

| Order | Filter | Purpose |
| --- | --- | --- |
| 1 | `GateFilter::class` | Removes items the current user is not authorized to see (`can`). |
| 2 | `HrefFilter::class` | Resolves the final `href` from `route` or `url`. |
| 3 | `ActiveFilter::class` | Marks the item active when it matches the current request. |
| 4 | `SearchFilter::class` | Normalizes `navbar-search` items (method, placeholder, url). |

See [menu.md](menu.md) for details on the filter pipeline.

---

## Menu

The `menu` key holds the sidebar (and optional top-nav) menu definition as an
array of item arrays. Because the menu is large and has its own item format
(headers, links, treeviews, badges, gates, etc.), it is documented separately
in [menu.md](menu.md).

---

## Translations / Locale

This package does not define a custom locale or fallback key in
`config/adminlte.php`. It uses Laravel's standard localization:

- Translation strings live in `resources/lang/{en,de,es}/` and are accessed with
  `__('adminlte.key')`.
- The active and fallback locales are controlled by your application's
  `config/app.php` (`locale`, `fallback_locale`) — not by this package.
- RTL rendering is toggled via the `layout_rtl` layout key (see the Layout
  Toggles section).
