# Demo / showcase pages

The package registers a set of bundled demo pages that mirror the AdminLTE 4
demo — dashboards, widget galleries, UI elements, form examples, tables, layout
options, a theme generator, alternate auth screens and error pages. They give a
fresh install something to look at and serve as living examples of the
components.

## How they're registered

`AdminLteServiceProvider::registerDemoRoutes()` wires them up. They are:

- **Enabled by default.** Controlled by `config('adminlte.demo', true)`.
- **Behind middleware.** Each route uses `config('adminlte.demo_middleware')`,
  which defaults to `['web', 'auth']`.
- **Plain view routes.** Each URI maps to a Blade view via `Route::view(...)`,
  named `adminlte.{dotted-uri}` (e.g. `demo/widgets/cards` →
  route name `adminlte.demo.widgets.cards`).

```php
if (! config('adminlte.demo', true)) {
    return;
}

$middleware = config('adminlte.demo_middleware', ['web', 'auth']);

Route::middleware($middleware)->group(function () use ($pages) {
    foreach ($pages as $uri => $view) {
        Route::view($uri, 'adminlte::'.$view)->name('adminlte.'.str_replace('/', '.', $uri));
    }
});
```

## Routes / URLs

| URL | View |
| --- | --- |
| `demo/dashboard-v2` | `demo.dashboard2` |
| `demo/dashboard-v3` | `demo.dashboard3` |
| `demo/theme-generator` | `demo.theme-generator` |
| `demo/layout-options` | `demo.layout-options` |
| `demo/widgets/small-box` | `demo.widgets.small-box` |
| `demo/widgets/info-box` | `demo.widgets.info-box` |
| `demo/widgets/cards` | `demo.widgets.cards` |
| `demo/ui/general` | `demo.ui.general` |
| `demo/ui/icons` | `demo.ui.icons` |
| `demo/ui/timeline` | `demo.ui.timeline` |
| `demo/forms/elements` | `demo.forms.elements` |
| `demo/forms/layout` | `demo.forms.layout` |
| `demo/forms/validation` | `demo.forms.validation` |
| `demo/forms/wizard` | `demo.forms.wizard` |
| `demo/tables/simple` | `demo.tables.simple` |
| `demo/tables/data` | `demo.tables.data` |
| `demo/auth/login-v2` | `auth.login-v2` |
| `demo/auth/register-v2` | `auth.register-v2` |
| `demo/auth/lockscreen` | `auth.lockscreen` |
| `demo/errors/404` | `errors.404` |
| `demo/errors/500` | `errors.500` |
| `demo/errors/maintenance` | `errors.maintenance` |

Route names are the URL with slashes replaced by dots and prefixed with
`adminlte.`, for example:

```php
route('adminlte.demo.dashboard-v2');     // demo/dashboard-v2
route('adminlte.demo.forms.wizard');     // demo/forms/wizard
route('adminlte.demo.errors.404');       // demo/errors/404
```

## Disabling demo pages in production

Turn the demo routes off entirely by setting `demo` to `false` in your published
`config/adminlte.php`:

```php
'demo' => false,
```

With this off, `registerDemoRoutes()` returns early and none of the routes are
registered. Alternatively, tighten access (rather than removing them) by changing
`demo_middleware`, for example to require an admin gate.
