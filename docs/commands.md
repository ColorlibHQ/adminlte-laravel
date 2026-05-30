# Artisan Commands

AdminLTE 4 for Laravel registers four Artisan commands. They handle installation,
status reporting, section scaffolding, and authentication scaffolding.

| Command | Purpose |
|---------|---------|
| `adminlte:install` | Publish config + Vite asset stubs and install/copy frontend dependencies |
| `adminlte:status` | Report which AdminLTE resources are installed |
| `adminlte:scaffold` | Scaffold full pre-built sections (mailbox, chat, kanban, …) with DB backing |
| `adminlte:make-auth` | Scaffold authentication (plain controllers, or Breeze/Fortify guidance) |

> For deep coverage of scaffolding see [`scaffolding.md`](scaffolding.md), and for
> authentication see [`authentication.md`](authentication.md).

---

## `adminlte:install`

Installs the core AdminLTE 4 scaffolding: the config file, the Vite CSS/JS entry
stubs, and the frontend npm dependencies (with vendor plugin files copied into
`public/vendor`).

### Signature

```text
adminlte:install
    {--only= : Install only a specific resource (config|views|assets|lang)}
    {--force : Overwrite existing files}
    {--no-interaction-deps : Skip the npm install prompt}
```

### Options

| Option | Description |
|--------|-------------|
| `--only=config` | Publish only `config/adminlte.php`. |
| `--only=views` | Publish the package views to `resources/views/vendor/adminlte`. |
| `--only=assets` | Publish the Vite entry stubs (`resources/js/adminlte.js`, `resources/css/adminlte.css`) and run the Vite-wiring check. |
| `--only=lang` | Publish language files to `lang/vendor/adminlte`. |
| `--force` | Pass `--force` to `vendor:publish`, overwriting existing files. |
| `--no-interaction-deps` | Skip the interactive npm install prompt (publish only). |

> Note: When `--only` is omitted, the command publishes **config** and **assets**
> (and wires Vite), then runs the frontend dependency installer. The `views` and
> `lang` resources are published **only** when explicitly requested via
> `--only=views` / `--only=lang`.

### What it publishes

The publishable tags (defined in `AdminLteServiceProvider`):

| Tag | Source | Destination |
|-----|--------|-------------|
| `adminlte-config` | `config/adminlte.php` | `config/adminlte.php` |
| `adminlte-views` | `resources/views` | `resources/views/vendor/adminlte` |
| `adminlte-assets` | `resources/stubs/app.js.stub`, `app.css.stub` | `resources/js/adminlte.js`, `resources/css/adminlte.css` |
| `adminlte-lang` | `resources/lang` | `lang/vendor/adminlte` |

### Vite wiring

After publishing assets, the installer inspects `vite.config.js`:

- If the file does not exist, nothing happens.
- If it already references `resources/js/adminlte.js`, it is left alone.
- Otherwise it prints a warning asking you to add
  `resources/css/adminlte.css` and `resources/js/adminlte.js` to the
  `laravel({ input: [...] })` array.

The installer never rewrites `vite.config.js` automatically (to avoid clobbering
custom configs).

### Frontend dependencies (npm)

When run without `--only` and without `--no-interaction-deps`, the command prompts:

> Install frontend dependencies (admin-lte, bootstrap, plugin libraries, etc.) via npm now?

If accepted, it runs:

```bash
npm install -D admin-lte@^4.0 bootstrap@^5.3 @popperjs/core overlayscrollbars \
  bootstrap-icons apexcharts jsvectormap fullcalendar sortablejs sass
```

| Package | Role |
|---------|------|
| `admin-lte@^4.0` | AdminLTE 4 core CSS/JS |
| `bootstrap@^5.3` | Bootstrap 5.3 framework |
| `@popperjs/core` | Tooltip/dropdown positioning (Bootstrap dependency) |
| `overlayscrollbars` | Custom sidebar scrollbars |
| `bootstrap-icons` | Icon font |
| `apexcharts` | Charts |
| `jsvectormap` | Vector maps |
| `fullcalendar` | Calendar section |
| `sortablejs` | Kanban drag-to-reorder |
| `sass` | SCSS compilation |

If the prompt is declined (or `--no-interaction-deps` is passed), the same command
is printed for you to run manually and the vendor copy step is skipped.

### Vendor file copying

After a successful npm install, the command copies plugin files from
`node_modules` into `public/vendor` (so they can be loaded directly by the layout
and section views). Files that don't exist in `node_modules` are silently skipped.

| Source (under `node_modules/`) | Destination (under `public/vendor/`) |
|--------------------------------|---------------------------------------|
| `apexcharts/dist/apexcharts.min.js` | `apexcharts/apexcharts.min.js` |
| `jsvectormap/dist/jsvectormap.min.css` | `jsvectormap/jsvectormap.min.css` |
| `jsvectormap/dist/jsvectormap.min.js` | `jsvectormap/jsvectormap.min.js` |
| `jsvectormap/dist/maps/world.js` | `jsvectormap/maps/world.js` |
| `fullcalendar/index.global.min.js` | `fullcalendar/index.global.min.js` |
| `sortablejs/Sortable.min.js` | `sortablejs/sortablejs.min.js` |
| `admin-lte/dist/css/adminlte.rtl.min.css` | `adminlte/css/adminlte.rtl.min.css` (RTL stylesheet, used when `layout_rtl` is enabled) |

### Next steps printed

```text
1. Ensure resources/js/adminlte.js & resources/css/adminlte.css are in your vite.config.js input.
2. Run npm run dev (or npm run build).
3. Extend the layout in a view: @extends('adminlte::page')
4. Configure your sidebar menu in config/adminlte.php.
```

### Examples

```bash
# Full install: config + assets + Vite check + npm deps (interactive)
php artisan adminlte:install

# Full install in CI / non-interactive (skip the npm prompt)
php artisan adminlte:install --no-interaction-deps

# Publish only the config file
php artisan adminlte:install --only=config

# Publish the views so you can customize them, overwriting existing files
php artisan adminlte:install --only=views --force

# Publish language files for translation overrides
php artisan adminlte:install --only=lang
```

---

## `adminlte:status`

Reports which AdminLTE resources are present on disk. Read-only — it makes no
changes.

### Signature

```text
adminlte:status
```

### What it checks

Each row is shown with a green ✓ (present) or red ✗ (missing):

| Check | Looks for |
|-------|-----------|
| Config | `config/adminlte.php` |
| JS stub | `resources/js/adminlte.js` |
| CSS stub | `resources/css/adminlte.css` |
| Published views | `resources/views/vendor/adminlte/` (directory) |
| `admin-lte` npm package | `node_modules/admin-lte/` |
| `bootstrap` npm package | `node_modules/bootstrap/` |
| RTL stylesheet | `public/vendor/adminlte/css/adminlte.rtl.min.css` |
| ApexCharts vendor file | `public/vendor/apexcharts/apexcharts.min.js` |
| jsVectorMap vendor file | `public/vendor/jsvectormap/jsvectormap.min.js` |
| FullCalendar vendor file | `public/vendor/fullcalendar/index.global.min.js` |
| SortableJS vendor file | `public/vendor/sortablejs/sortablejs.min.js` |
| Scaffolded sections | `resources/views/adminlte/` (directory) |

If anything is missing, it prints a warning to run `php artisan adminlte:install`.
If everything is present, it prints "AdminLTE 4 is fully installed."

### Example

```bash
php artisan adminlte:status
```

---

## `adminlte:scaffold`

Scaffolds full pre-built sections (mailbox, chat, kanban, calendar, projects,
file-manager, profile, settings, invoice, pricing, faq), publishing migrations,
models, controllers, seeders, views, and routes per a declarative manifest.

### Signature

```text
adminlte:scaffold
    {section? : The section to scaffold}
    {--all : Scaffold all sections}
    {--force : Overwrite existing files}
    {--seed : Run seeders after publishing}
```

### Options

| Option | Description |
|--------|-------------|
| `section` (argument, optional) | One of the 18 section names (see [`scaffolding.md`](scaffolding.md)). Omit it (without `--all`) for an interactive multi-select prompt. |
| `--all` | Scaffold every section. |
| `--force` | Overwrite existing files instead of skipping them. |
| `--seed` | After publishing, run `migrate --force` and `db:seed` for the section's seeder. |

### Examples

```bash
# Interactive multi-select picker
php artisan adminlte:scaffold

# Scaffold one section
php artisan adminlte:scaffold kanban

# Scaffold one section, then migrate and seed demo data
php artisan adminlte:scaffold mailbox --seed

# Scaffold everything
php artisan adminlte:scaffold --all

# Re-scaffold and overwrite customizations
php artisan adminlte:scaffold projects --force

# Roles & permissions layer (HasRoles on User, users/roles UI), seeded
php artisan adminlte:scaffold rbac --seed
```

DB-backed sections also publish **factories, form requests, policies, and feature
tests** alongside the model and controller — see [`scaffolding.md`](scaffolding.md).
The `rbac` section installs a dependency-free roles/permissions layer — see
[`authorization.md`](authorization.md).

See [`scaffolding.md`](scaffolding.md) for the full per-section manifest, the DB
tables created, and the route group injected into `routes/web.php`.

---

## `adminlte:make-auth`

Scaffolds authentication. In `plain` mode it publishes self-contained auth
controllers and registers their routes; `breeze` and `fortify` print integration
guidance.

### Signature

```text
adminlte:make-auth
    {--type=plain : Auth type (plain, breeze, fortify)}
    {--force : Overwrite existing files}
```

### Options

| Option | Description |
|--------|-------------|
| `--type=plain` (default) | Publish `Login`/`Register`/`ForgotPassword`/`ResetPassword` controllers and append auth routes to `routes/web.php`. |
| `--type=breeze` | Print Laravel Breeze integration steps (no files published). |
| `--type=fortify` | Print Laravel Fortify integration steps (no files published). |
| `--force` | Overwrite existing controller files (plain mode). |

An invalid `--type` value fails the command.

### Examples

```bash
# Plain auth (controllers + routes)
php artisan adminlte:make-auth

# Plain auth, overwrite existing controllers
php artisan adminlte:make-auth --type=plain --force

# Breeze integration guidance
php artisan adminlte:make-auth --type=breeze

# Fortify integration guidance
php artisan adminlte:make-auth --type=fortify
```

See [`authentication.md`](authentication.md) for the published controllers, the
registered routes, and the shipped auth views.
