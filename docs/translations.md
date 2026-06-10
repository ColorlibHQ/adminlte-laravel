# Translations (i18n)

All package views — the auth screens, navbar dropdowns, user menu, command
palette, and components — use Laravel's translation helper with the `adminlte`
group, e.g. `__('adminlte.search')` or `__('adminlte.sign_out')`. The package
ships roughly 220 keys per locale, covering the layout, auth flows, account
management, sessions, impersonation, API tokens, the activity log, and the
RBAC management UI.

## Bundled locales

Nine locales ship under `resources/lang/`, each with a single `adminlte.php`
file. **Every locale is complete** — all nine carry the full key set, so no
locale silently falls back to English:

| Code | Language |
| --- | --- |
| `en` | English |
| `de` | German |
| `es` | Spanish |
| `fr` | French |
| `it` | Italian |
| `pt_BR` | Portuguese (Brazil) |
| `ru` | Russian |
| `zh` | Chinese |
| `ja` | Japanese |

## How keys resolve

`AdminLteServiceProvider::registerTranslations()` registers the package lang
directory two ways:

1. As a namespaced source via `loadTranslationsFrom($langPath, 'adminlte')`, so
   the keys are reachable as `__('adminlte::adminlte.key')`.
2. As an **additional default-namespace path** by calling `addPath()` on the
   translation `FileLoader`. This makes the same keys resolve as plain
   `__('adminlte.key')` — i.e. the `adminlte` group in the default namespace —
   with no publishing step required.

```php
$this->loadTranslationsFrom($langPath, 'adminlte');

$loader = $this->app->make('translator')->getLoader();
if ($loader instanceof FileLoader) {
    $loader->addPath($langPath);
}
```

Both forms work out of the box:

```php
__('adminlte.search');            // default namespace (used throughout the views)
__('adminlte::adminlte.key');     // explicit package namespace
```

## Publishing and overriding translations

To customize wording or add keys, publish the language files into your app:

```bash
php artisan adminlte:install --only=lang
```

This copies `resources/lang` to `lang/vendor/adminlte` (the publish tag is
`adminlte-lang`, mapping to `lang_path('vendor/adminlte')`). Files placed there
override the package's defaults for matching locales and keys. You can also add a
locale the package doesn't ship by creating
`lang/vendor/adminlte/{locale}/adminlte.php`.

## Setting the application locale

Translations follow Laravel's active locale. Set the default in
`config/app.php` (`'locale' => 'de'`), or change it at runtime:

```php
App::setLocale('de');
```

The master layout reflects the active locale on the `<html lang="...">`
attribute (converting underscores to hyphens, e.g. `pt_BR` → `pt-BR`).

## Contributing a locale or fixing a translation

PRs are welcome — copy `resources/lang/en/adminlte.php` to your locale
directory and translate the values (never the keys; keep placeholders like
`:name` intact). New keys must be added to **all nine** locale files in the
same change. You can verify completeness with:

```bash
php -r '$en = require "resources/lang/en/adminlte.php";
foreach (["de","es","fr","it","ja","pt_BR","ru","zh"] as $l)
    echo $l, ": ", count(array_diff_key($en, require "resources/lang/$l/adminlte.php")), PHP_EOL;'
```

Every line should print `0`. See [contributing.md](contributing.md).
