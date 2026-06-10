# Menu System

The sidebar (and optional top-nav) menu is defined as an array under the `menu`
key in `config/adminlte.php`. Each element of the array is a single **menu
item** described by an associative array. Items pass through a filter pipeline
before they are rendered by `resources/views/partials/menu-item.blade.php`.

- Config: `config/adminlte.php` (`'menu'` array, `'filters'` array)
- Builder: `src/AdminLte.php`
- Helpers: `src/Menu/MenuItemHelper.php`
- Filters: `src/Menu/Filters/*.php`
- View: `resources/views/partials/menu-item.blade.php`

---

## Item Types

### Section Header

A non-clickable label that groups items. Rendered as `<li class="nav-header">`.

```php
['header' => 'PAGES'],
```

| Key | Required | Description |
| --- | --- | --- |
| `header` | yes | The uppercase section label text. |

`MenuItemHelper::isHeader()` returns `true` when an item has a `header` key.

### Link

A standard navigation link. Requires `text` plus a destination (`url` or
`route`).

```php
[
    'text'  => 'Dashboard',
    'url'   => '/',
    'icon'  => 'bi bi-speedometer',
],
```

| Key | Required | Description |
| --- | --- | --- |
| `text` | yes | The link label. |
| `url` | one of | Raw URL (relative or absolute). |
| `route` | one of | Named route. String, or `[name, params]` array. |
| `icon` | no | Bootstrap Icons class (e.g. `bi bi-speedometer`). Defaults to `bi bi-circle` if omitted. |
| `icon_color` | no | Color suffix → renders `text-{color}` on the icon. |
| `label` | no | Badge value shown after the text. |
| `label_color` | no | Badge color (`text-bg-{color}`). Defaults to `primary`. |
| `target` | no | Anchor `target` (e.g. `_blank`). Adds `rel="noopener"` automatically. |
| `can` | no | Gate ability (string or array) required to display the item. |
| `can_params` | no | Model/argument passed to the gate check. |
| `active` | no | URL pattern(s) (string or array) that mark the item active. |

`MenuItemHelper::isLink()` returns `true` for any item with `text` that is not a
search box.

### Treeview / Submenu

An item with a `submenu` array becomes a collapsible treeview. Submenus can be
**nested to any depth** — the menu-item view includes itself recursively.

```php
[
    'text' => 'Widgets',
    'icon' => 'bi bi-box-seam-fill',
    'submenu' => [
        ['text' => 'Small Box', 'url' => 'demo/widgets/small-box', 'icon' => 'bi bi-circle'],
        ['text' => 'Info Box',  'url' => 'demo/widgets/info-box',  'icon' => 'bi bi-circle'],
        [
            'text' => 'Nested',
            'icon' => 'bi bi-circle',
            'submenu' => [
                ['text' => 'Deep Item', 'url' => '#', 'icon' => 'bi bi-record-circle-fill'],
            ],
        ],
    ],
],
```

| Key | Required | Description |
| --- | --- | --- |
| `text` | yes | The parent label. |
| `icon` | no | Icon for the parent item. |
| `submenu` | yes | Array of child items (any of the item types, including more submenus). |

A treeview parent uses `href="#"`; the `route`/`url` keys are not needed on it.
`MenuItemHelper::isSubmenu()` returns `true` when `submenu` is an array. A parent
is automatically expanded (`menu-open`) and marked `active` when any descendant
is active.

### Search Box

A navbar search input, identified by `type => 'navbar-search'`.

```php
[
    'type'        => 'navbar-search',
    'method'      => 'get',     // normalized default
    'placeholder' => 'Search',  // normalized default
    'url'         => 'search',   // normalized default '#'
    'topnav_right' => true,
],
```

`SearchFilter` fills in `method` (`get`), `placeholder` (`Search`), and `url`
(`#`) when they are omitted.

---

## Badges & Icon Colors

Both link and treeview items support a badge and a colored icon.

```php
['text' => 'Inbox', 'url' => 'admin/mailbox', 'icon' => 'bi bi-envelope', 'label' => 12, 'label_color' => 'danger'],
['text' => 'Important', 'url' => '#', 'icon' => 'bi bi-circle', 'icon_color' => 'danger'],
```

- `label` renders a badge: `<span class="nav-badge badge text-bg-{label_color}">`.
- `label_color` defaults to `primary` if omitted.
- `icon_color` adds `text-{icon_color}` to the `<i class="nav-icon ...">`.

---

## URL vs Route Resolution (`HrefFilter`)

`HrefFilter` computes the final `href` for each item (and recurses into
submenus). Resolution order:

1. If `href` is already set, it is kept as-is.
2. Headers and `navbar-search` items get no `href`.
3. `route` → resolved with Laravel's `route()` helper.
   - String form: `route($item['route'])`.
   - Array form: `route($item['route'][0], $item['route'][1] ?? [])` for params.
4. `url` → external URLs (matching `//`, `mailto:`, `tel:`) are used verbatim;
   otherwise passed through `url()`.
5. If none of the above, `href` falls back to `'#'`.

```php
['text' => 'Users',   'route' => 'users.index'],            // route('users.index')
['text' => 'Edit',    'route' => ['users.edit', ['id' => 1]]], // route with params
['text' => 'Docs',    'url'   => 'https://example.com', 'target' => '_blank'], // external, kept as-is
['text' => 'Local',   'url'   => 'admin/users'],            // url('admin/users')
```

---

## Active-State Marking (`ActiveFilter`)

`ActiveFilter` decides whether an item is highlighted as the current page:

- If `active` is already a boolean, it is respected as-is.
- If `active` is a pattern (or list of patterns), the item is active when the
  current request matches any pattern via `Request::is()`.
- If no `active` pattern is given, one is **auto-derived from `url`**: for a URL
  `admin/users` it matches both `admin/users` and `admin/users/*`. A `url` of
  `'/'` matches only the site root; `'#'` is never auto-matched.
- A submenu parent becomes active if **any child** is active (recursively).

```php
// Explicit patterns:
['text' => 'Users', 'url' => 'admin/users', 'active' => ['admin/users*', 'admin/people*']],
```

In the view, an active item gets the `active` class; an active treeview parent
also gets `menu-open` so it renders expanded.

---

## Gate Filtering (`GateFilter`)

`GateFilter` removes items the current user is not authorized to see:

- Only items with a `can` key are checked; others pass through untouched.
- `can` may be a single ability string or an array of abilities. The item is
  shown if the user passes **any** of them (`Gate::allows`).
- `can_params` is forwarded to the gate as the model/argument.
- Returning `null` from the filter drops the item from the menu entirely.

```php
['text' => 'Admin Panel', 'url' => 'admin', 'can' => 'access-admin'],
['text' => 'Edit Post',   'route' => 'posts.edit', 'can' => 'update', 'can_params' => $post],
```

---

## The Filter Pipeline

Filters are listed in `config('adminlte.filters')` and run **in array order** by
`AdminLte::buildFiltered()`. Each filter implements `FilterInterface` with a
single method:

```php
public function transform(array $item): ?array;
```

It returns the (possibly modified) item, or `null` to remove it entirely. The
default pipeline order is:

| Order | Filter | Effect |
| --- | --- | --- |
| 1 | `GateFilter` | Drops unauthorized items (`can`). |
| 2 | `HrefFilter` | Resolves `href` from `route` / `url`. |
| 3 | `ActiveFilter` | Marks the active item / treeview branch. |
| 4 | `SearchFilter` | Normalizes `navbar-search` items. |

The result is cached on the `AdminLte` instance for the request. Add custom
filters by appending your own `FilterInterface` class to the `filters` array.

---

## Scoped Menus

`AdminLte` is registered as a singleton; resolve it via `app('adminlte')`. The
`menu()` method returns the filtered menu for a given scope:

```php
app('adminlte')->menu('sidebar');       // items not flagged topnav-only
app('adminlte')->menu('navbar-left');   // items with 'topnav' => true
app('adminlte')->menu('navbar-right');  // items with 'topnav_right' => true
app('adminlte')->menu();                // the full filtered list
```

Scope rules (see `MenuItemHelper`):

- **sidebar**: items where both `topnav` and `topnav_right` are empty.
- **navbar-left**: items with a truthy `topnav` key.
- **navbar-right**: items with a truthy `topnav_right` key.

```php
// Place an item in the right side of the top navbar instead of the sidebar:
['text' => 'Help', 'url' => 'help', 'icon' => 'bi bi-question-circle', 'topnav_right' => true],
```

---

## Runtime Additions (`addAfter` / `add`)

Items can be added at runtime (e.g. from a service provider's `boot()`),
which is useful for package- or permission-driven menus:

```php
// Insert directly after the item whose `key`, `text` or `header` matches:
app('adminlte')->addAfter('Dashboard',
    ['header' => 'REPORTS'],
    ['text' => 'Sales', 'route' => 'reports.sales', 'icon' => 'bi bi-graph-up'],
);

// Or simply append to the end of the menu:
app('adminlte')->add(
    ['text' => 'Status', 'url' => 'status', 'icon' => 'bi bi-activity'],
);
```

Give menu items an explicit `'key' => 'dashboard'` attribute when you want a
stable anchor for `addAfter()` that survives text changes and translation. If
no item matches the given key, the items are appended to the end.

Because the menu builder is a singleton, runtime additions persist for the rest
of the request and reset on the next request.

---

## Realistic Example

```php
'menu' => [
    // Section header
    ['header' => 'MAIN'],

    // Simple link
    [
        'text' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'bi bi-speedometer',
    ],

    // Treeview with a badge on the parent and an authorization gate
    [
        'text' => 'Shop',
        'icon' => 'bi bi-bag',
        'label' => 3,
        'label_color' => 'danger',
        'can' => 'manage-shop',
        'submenu' => [
            ['text' => 'Orders',   'route' => 'orders.index',   'icon' => 'bi bi-circle'],
            ['text' => 'Products', 'route' => 'products.index', 'icon' => 'bi bi-circle'],
        ],
    ],

    ['header' => 'OTHER'],

    // External link opening in a new tab
    [
        'text' => 'Documentation',
        'url' => 'https://adminlte.io/docs',
        'icon' => 'bi bi-book',
        'target' => '_blank',
    ],

    // Colored-icon link
    [
        'text' => 'Important',
        'url' => '#',
        'icon' => 'bi bi-exclamation-triangle',
        'icon_color' => 'warning',
    ],
],
```
