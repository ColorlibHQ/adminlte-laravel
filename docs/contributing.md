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

All three must pass before a PR is merged (they also run in CI). Composer
scripts wrap the right flags for you:

```bash
composer lint       # code style check (Laravel Pint, PSR-12)
composer fix        # code style, applying fixes
composer analyse    # static analysis (Larastan / PHPStan level 8,
                    # with the required --memory-limit baked in)
composer test       # PHPUnit via Testbench
composer check      # all three, in CI order

# Run a single test:
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
- **New translation key?** Add it to **all 9** locale files in
  `resources/lang/` — every locale ships complete, and PRs that add keys only
  to `en` will be asked to backfill. Verify with:

  ```bash
  php -r '$en = require "resources/lang/en/adminlte.php";
  foreach (["de","es","fr","it","ja","pt_BR","ru","zh"] as $l)
      echo $l, ": ", count(array_diff_key($en, require "resources/lang/$l/adminlte.php")), PHP_EOL;'
  # every line must print 0
  ```

- **Accessibility**: decorative icons get `aria-hidden="true"`; form errors are
  linked to their control via `aria-describedby`; interactive toggles expose
  state (`aria-expanded`). Keep new views to the same standard.

## Reporting security issues

Please don't open public issues for vulnerabilities — use
[GitHub Security Advisories](https://github.com/ColorlibHQ/adminlte-laravel/security/advisories/new)
(see `.github/SECURITY.md`).

## CI

GitHub Actions runs the matrix on PHP 8.3 / 8.4 / 8.5 with Laravel 13:
**composer lint → composer analyse → composer test**. All steps must be green.
Dependabot keeps Composer dev-dependencies and the workflow actions current.
