# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**AdminLTE 4 for Laravel** is an official Laravel package integration of AdminLTE 4 (Bootstrap 5.3, vanilla JS). It provides:

- Config-driven sidebar menu with permissions, active states, badges
- 21+ Blade components (cards, widgets, forms, modals, navbar dropdowns)
- Multi-language support (i18n) with English, German, Spanish translations
- Plugin system for lazy-loading JS libraries (Flatpickr, Tom Select, Tabulator, Quill)
- RTL layout support
- Auth views (login, register, forgot-password, reset-password)
- Vite-first asset pipeline

This is a **package** (Composer), not a Laravel application. The package provides reusable components and infrastructure for Laravel apps that consume it.

## Development Commands

### Testing & Quality Assurance

```bash
# Run tests (PHPUnit)
composer test
# or: vendor/bin/phpunit

# Run single test class/method
vendor/bin/phpunit tests/SmokeTest.php
vendor/bin/phpunit tests/SmokeTest.php --filter testComponentsRenderWithoutErrors

# Check code style (Pint/Laravel's formatter)
vendor/bin/pint
vendor/bin/pint --test    # check only, don't fix

# Run static analysis (Larastan + phpstan)
vendor/bin/phpstan
vendor/bin/phpstan --memory-limit=2G  # if hitting memory limits
```

### Installation & Setup

```bash
# Install dependencies
composer install

# The package itself is never "run" — it's consumed by Laravel apps via:
# composer require colorlibhq/adminlte-laravel
# php artisan adminlte:install
```

## Architecture & Key Concepts

### Service Provider (`AdminLteServiceProvider`)

- Registers 27 Blade components under the `adminlte-` prefix (e.g., `<x-adminlte-card>`)
- Registers the `AdminLte` singleton (menu builder) and `PluginManager` singleton
- Registers `@pluginStyles` and `@pluginScripts` Blade directives
- Publishes config, views, stubs, and language files
- Registers Artisan commands: `adminlte:install`, `adminlte:status`

### Core Components

#### Menu System (`AdminLte` + `MenuItemHelper`)

- **`AdminLte` class** (singleton): Builds and filters the sidebar menu from config
- Menu items flow through a **filter pipeline** (`config/adminlte.filters`):
  1. `SearchFilter` — normalizes menu data
  2. `GateFilter` — filters by authorization (`can` key)
  3. `HrefFilter` — resolves routes to URLs
  4. `ActiveFilter` — marks current page as active
- Supports nested submenus, badges, icons, section headers, navbar items
- Singleton ensures runtime `addAfter()` calls persist for the request
- Scoped menu retrieval: `menu('sidebar')`, `menu('navbar-left')`, `menu('navbar-right')`

#### Plugin System (`PluginManager`)

- Lazy-loads optional JS/CSS libraries (Flatpickr, Tom Select, Tabulator, Quill)
- Config in `config/adminlte.php` under `plugins` key
- Components like `<x-adminlte-input-flatpickr>` trigger plugin registration
- `@pluginStyles` / `@pluginScripts` directives inject assets

#### Blade Components

**Location:** `src/View/Components/{Form,Widget,Tool}/` (corresponds to view files in `resources/views/components/`)

**Categories:**

- **Widget components** (`Widget/`): Card, SmallBox, InfoBox, Alert, Callout, Progress, Timeline, ProgressGroup, DescriptionBlock, ProfileCard, Ratings, NavNotifications, NavMessages, NavTasks
- **Form components** (`Form/`): Input, InputSwitch, InputColor, InputFile, InputFlatpickr (plugin), InputTomSelect (plugin), Textarea, Select, Button
- **Tool components** (`Tool/`): Modal, Datatable (plugin), Editor (plugin)

**Component Structure:**

```php
// src/View/Components/Widget/Card.php
class Card extends Component {
    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $theme = null,  // primary, success, warning, danger, info
        public bool $outline = false,
        // ... more options
    ) {}

    public function cardClass(): string {
        // Helper to build dynamic CSS classes
    }

    public function render(): View {
        return view('adminlte::components.widget.card');  // maps to resources/views/components/widget/card.blade.php
    }
}
```

**Key Patterns:**

- Constructor parameters become component attributes
- Private helper methods (like `cardClass()`) compute dynamic classes or conditional content
- `render()` points to the corresponding Blade view
- Views are namespaced: `adminlte::` namespace points to `resources/views/`

#### Config

- **`config/adminlte.php`**: Title, logo, layout toggles, color-mode, sidebar theme, user menu, menu definition, filters, plugins, language fallback
- **Published during install** via `php artisan adminlte:install`
- Menu defined as array of items: `['text' => 'Page', 'route' => 'page.show', 'icon' => 'bi bi-home']`

### Language/Translation

- **Location:** `resources/lang/{en,de,es}/`
- All auth views and components use the `__('adminlte.key')` pattern
- Form validation messages, buttons, labels are translatable
- 7 additional language stubs (French, Italian, Portuguese, Russian, Turkish, Ukrainian, Japanese) for user extension

## Testing

### Test Structure

- **Location:** `tests/`
- **Test case base:** `TestCase.php` extends Orchestra Testbench (isolates package tests from a parent app)
- **Key test files:**
  - `SmokeTest.php` — component rendering, menu filtering, auth views
  - `PluginSystemTest.php` — plugin registration and directive output
  - `WidgetComponentTest.php` — widget-specific assertions

### Testing Patterns

```php
// Components render without errors
$view = view('adminlte::components.widget.card', [
    'title' => 'Test',
    'icon' => 'bi bi-home',
])->render();
$this->assertStringContainsString('card', $view);

// Menu items are filtered correctly
$menu = app('adminlte')->menu('sidebar');
$this->assertCount(2, $menu);

// Plugin manager tracks enabled plugins
$this->assertTrue(app(PluginManager::class)->isEnabled('flatpickr'));
```

### CI/CD (GitHub Actions)

- Runs on PHP 8.3 and 8.4 with Laravel 13
- Steps: **Pint** (code style) → **Larastan** (static analysis) → **PHPUnit** (tests)
- All steps must pass for PR merge

## Common Development Patterns

### Adding a New Component

1. **Create the PHP class** in `src/View/Components/{Category}/YourComponent.php`
   - Extend `Illuminate\View\Component`
   - Define public constructor parameters (become tag attributes)
   - Add private helper methods for computed CSS/logic
   - Implement `render()` returning a Blade view

2. **Create the Blade view** in `resources/views/components/{category}/your-component.blade.php`
   - Use `$slot` for content slots
   - Reference component properties directly: `{{ $title }}`
   - Call helper methods: `{{ $this->cardClass() }}`

3. **Register in `AdminLteServiceProvider`**
   ```php
   private array $components = [
       'your-component' => Components\Category\YourComponent::class,
   ];
   ```
   - Used as `<x-adminlte-your-component>`

4. **Test it** in `tests/WidgetComponentTest.php` or similar
   - Render with sample data
   - Assert key strings are present

### Adding a New Filter

1. **Create the filter** in `src/Menu/Filters/YourFilter.php`
   - Implement `FilterInterface` (single method: `transform(array $item): ?array`)
   - Return null to drop the item; otherwise modify and return

2. **Register in `config/adminlte.php`**
   ```php
   'filters' => [
       // ... existing filters
       YourFilter::class,
   ],
   ```

3. **Test the filter** — unit test or integration test via menu rendering

### Adding a Plugin

1. **Register in `config/adminlte.php`**
   ```php
   'plugins' => [
       'your-lib' => [
           'enabled' => true,
           'css' => 'your-lib.min.css',
           'js' => 'your-lib.min.js',
       ],
   ],
   ```

2. **Create a component that depends on it** (e.g., `InputYourLib`)
   - Constructor calls `app(PluginManager::class)->require('your-lib')`
   - Component render triggers plugin registration automatically

3. **Test via `@pluginStyles` and `@pluginScripts`** directives
   - Verify asset URLs are present in rendered output

## File Structure Summary

```
src/
  AdminLte.php                    # Menu builder singleton
  AdminLteServiceProvider.php     # Main service provider
  Console/
    InstallCommand.php            # php artisan adminlte:install
    StatusCommand.php             # php artisan adminlte:status
  Menu/
    MenuItemHelper.php            # Static menu utilities
    Filters/
      FilterInterface.php         # Filter contract
      SearchFilter.php            # Data normalization
      GateFilter.php              # Authorization
      HrefFilter.php              # Route/URL resolution
      ActiveFilter.php            # Active state marking
  Plugins/
    PluginManager.php             # JS library management
  View/Components/
    Form/                         # 9 form components
    Widget/                       # 12 widget components
    Tool/                         # 3 tool components

resources/
  views/
    components/                   # Blade templates for each component
    layouts/                      # master, page layouts
    partials/                     # navbar, sidebar, footer, etc.
    auth/                         # login, register, etc.
  lang/
    en/, de/, es/                 # Translation files
  stubs/
    app.js.stub, app.css.stub     # Vite entry stubs

tests/
  TestCase.php                    # Testbench base
  SmokeTest.php                   # Rendering & integration tests
  PluginSystemTest.php            # Plugin system tests
  WidgetComponentTest.php         # Widget-specific tests

config/
  adminlte.php                    # Published to consumer's config/

phpunit.xml.dist                  # PHPUnit config
phpstan.neon                      # Larastan config (level 8)
```

## Code Style & Standards

- **PHP Style:** PSR-12 (enforced via Pint)
- **Static Analysis:** PHPStan level 8 via Larastan
- **Type Hints:** Strict types, explicit return types on all methods
- **Documentation:** Inline doc blocks for public APIs
- **Naming:** Camel case (PHP methods), kebab-case (Blade component tags and view names)

## Important Notes

- **This is a package**, not a consuming Laravel app. Tests use Orchestra Testbench to isolate the package.
- **Menu is a singleton** — runtime `addAfter()` calls persist for the request but reset on the next request.
- **Components are published during install** — config, views, stubs can be customized by the consuming app.
- **Filters run in order** — the filter pipeline is the single source of truth for menu rendering logic.
- **Plugins are lazy** — assets only load if a component explicitly requires them.
