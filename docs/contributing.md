# Contributing & Development

Thanks for helping improve AdminLTE 4 for Laravel.

## Local setup

This is a **package**, not an application — it's developed in isolation using
[Orchestra Testbench](https://github.com/orchestral/testbench).

```bash
git clone https://github.com/colorlibhq/adminlte-laravel.git
cd adminlte-laravel
composer install
```

## Quality gates

All three must pass before a PR is merged (they also run in CI):

```bash
# Code style (Laravel Pint, PSR-12)
vendor/bin/pint            # fix
vendor/bin/pint --test     # check only

# Static analysis (Larastan / PHPStan level 8)
vendor/bin/phpstan analyse --memory-limit=2G

# Tests (PHPUnit via Testbench)
composer test
# or a single test:
vendor/bin/phpunit tests/SmokeTest.php --filter testComponentsRenderWithoutErrors
```

PHPStan runs at **level 8** with zero baseline — keep it clean. The only
ignored rule is the package-namespaced `view()` false-positive (see
`phpstan.neon`).

## Project layout

```
src/
  AdminLte.php                  Menu builder (singleton)
  AdminLteServiceProvider.php   Components, directives, demo routes, publishing
  Console/                      install, status, scaffold, make-auth commands
  Menu/                         MenuItemHelper + the filter pipeline
  Plugins/PluginManager.php     Lazy JS-library management
  View/Components/{Widget,Form,Tool}/

resources/
  views/                        layouts, partials, components, auth, errors, demo
  lang/                         9 locales
  stubs/                        Vite entries + scaffold stubs (migrations,
                                models, controllers, seeders, routes, views)
config/adminlte.php             Published config

tests/                          Testbench-based tests
docs/                           This documentation
```

## Conventions

- **PHP**: PSR-12, strict types, explicit return types, doc-blocks on public APIs.
- **Blade tags**: kebab-case (`<x-adminlte-small-box>`); view names kebab-case.
- **New component?** Add the class under `src/View/Components/{Category}/`, the
  view under `resources/views/components/{category}/`, register it in the
  `$components` map in `AdminLteServiceProvider`, document it in
  [components.md](components.md), and add a render test.
- **New translation key?** Add it to `resources/lang/en/adminlte.php` (the other
  locales fall back to English until translated).

## CI

GitHub Actions runs the matrix on PHP 8.3 / 8.4 with Laravel 13:
**Pint → Larastan → PHPUnit**. All steps must be green.
