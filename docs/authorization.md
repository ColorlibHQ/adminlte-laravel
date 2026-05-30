# Authorization (Roles & Permissions)

AdminLTE for Laravel ships an optional, **dependency-free RBAC layer** — roles,
permissions, a `HasRoles` trait on your `User` model, route middleware, a
permission-aware Gate, and a management UI for users and roles. There is no
third-party package to install: everything is published into your app as plain
Laravel code you own and can edit.

It's scaffolded in one command:

```bash
php artisan adminlte:scaffold rbac --seed
```

> RBAC is entirely optional. The package detects whether you've published it
> (via `class_exists`) and only wires policies, middleware aliases, and the Gate
> when the classes are present. Apps that never scaffold `rbac` are unaffected.

---

## What `adminlte:scaffold rbac` publishes

| Artifact | Destination |
|----------|-------------|
| Migration (4 tables) | `database/migrations/{timestamp}_create_adminlte_rbac_tables.php` |
| `Role` model | `app/Models/Role.php` |
| `Permission` model | `app/Models/Permission.php` |
| `HasRoles` trait | `app/Models/Concerns/HasRoles.php` |
| `RoleMiddleware` | `app/Http/Middleware/RoleMiddleware.php` |
| `PermissionMiddleware` | `app/Http/Middleware/PermissionMiddleware.php` |
| Seeder | `database/seeders/AdminLteRbacSeeder.php` |
| Factories | `database/factories/{Role,Permission}Factory.php` |
| Controllers | `app/Http/Controllers/AdminLte/{UserController,RoleController}.php` |
| Views | `resources/views/adminlte/{users,roles}/` (index, create, edit) |
| Routes | `users` + `roles` appended to the managed group in `routes/web.php` |

In addition, the command **edits your `User` model** to add the trait (idempotent
— safe to re-run):

```php
use App\Models\Concerns\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

### Database tables

| Table | Purpose |
|-------|---------|
| `adminlte_roles` | `id`, `name`, `label`, timestamps |
| `adminlte_permissions` | `id`, `name`, `label`, timestamps |
| `adminlte_role_user` | pivot: role ↔ user |
| `adminlte_permission_role` | pivot: permission ↔ role |

---

## How the package wires it up

When the RBAC classes exist, `AdminLteServiceProvider` does three things at boot
(`registerAuthorization()`):

1. **Registers model policies** for the scaffolded resources (only those whose
   model *and* policy classes both exist):

   | Model | Policy |
   |-------|--------|
   | `App\Models\Message` | `MessagePolicy` |
   | `App\Models\Project` | `ProjectPolicy` |
   | `App\Models\Event` | `EventPolicy` |
   | `App\Models\KanbanCard` | `KanbanCardPolicy` |
   | `App\Models\Conversation` | `ConversationPolicy` |

2. **Aliases the middleware** so you can use `role:` and `permission:` on routes:

   ```php
   Route::middleware('role:admin')->group(/* ... */);
   Route::middleware('permission:manage-users')->group(/* ... */);
   ```

3. **Registers a permission-aware `Gate::before`** so abilities resolve against
   permissions automatically:

   ```php
   Gate::before(function ($user, string $ability) {
       if ($user->isAdmin()) return true;                       // admins pass everything
       if ($user->hasPermission($ability)) return true;         // e.g. @can('manage-projects')
       return null;                                             // otherwise fall through to policies
   });
   ```

   This means a permission named `manage-projects` makes `@can('manage-projects')`,
   `$user->can('manage-projects')`, and a menu item's `'can' => 'manage-projects'`
   all work with no extra code.

---

## Using it

### On the User model

The `HasRoles` trait adds:

| Method | Returns | Description |
|--------|---------|-------------|
| `roles()` | `BelongsToMany` | The user's roles relationship. |
| `hasRole(string\|array $role)` | `bool` | True if the user has any of the given role name(s). |
| `hasPermission(string $name)` | `bool` | True if any of the user's roles grants the permission. |
| `assignRole(string $role)` | `void` | Attach a role by name. |
| `isAdmin()` | `bool` | Shortcut for `hasRole('admin')`. |

```php
$user->assignRole('editor');
$user->hasRole('admin');                 // false
$user->hasRole(['admin', 'editor']);     // true
$user->hasPermission('manage-projects'); // true
```

### On routes

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // admin-only
});

Route::get('/reports', ReportController::class)
    ->middleware('permission:view-reports');
```

`role:` accepts multiple roles (`role:admin,editor` — passes if the user has
*any*). `permission:` takes a single permission name.

### In Blade and controllers

Because of the `Gate::before` hook, permissions behave like Gate abilities:

```blade
@can('manage-users')
    <a href="{{ route('adminlte.users.index') }}">Manage users</a>
@endcan
```

```php
$this->authorize('manage-roles');
Gate::allows('manage-projects');
```

### Gating the sidebar menu

Menu items support a `can` key, filtered by the package's `GateFilter`. Combined
with the Gate hook above, you can gate a menu entry on a permission name:

```php
// config/adminlte.php
['header' => 'administration'],
['text' => 'users', 'route' => 'adminlte.users.index', 'icon' => 'bi bi-people', 'can' => 'manage-users'],
['text' => 'roles', 'route' => 'adminlte.roles.index', 'icon' => 'bi bi-shield-lock', 'can' => 'manage-roles'],
```

Users without the permission simply never see the item. The package's default
config already includes this **Administration** section.

---

## Default roles & permissions (seeder)

`AdminLteRbacSeeder` creates the following and is run by `--seed`:

**Permissions:** `view-dashboard`, `view-reports`, `manage-users`, `manage-roles`,
`manage-projects`, `manage-mailbox`, `manage-kanban`, `manage-calendar`,
`manage-settings`.

**Roles:**

| Role | Label | Permissions |
|------|-------|-------------|
| `admin` | Administrator | all permissions (and `isAdmin()` passes every gate) |
| `editor` | Editor | the `manage-*` content permissions |
| `viewer` | Viewer | `view-dashboard`, `view-reports` |

The seeder assigns the **`admin` role to the first user** in the table, so the
account you register first becomes the administrator.

---

## Management UI

Scaffolding `rbac` adds two CRUD screens under the auth-protected `/admin` group:

| Page | URL | Route name |
|------|-----|------------|
| Users — list, create, edit, assign roles, delete | `/admin/users` | `adminlte.users.*` |
| Roles — list, create, edit, assign permissions, delete | `/admin/roles` | `adminlte.roles.*` |

Both pages are gated by `manage-users` / `manage-roles` via the menu `can` keys
and the controllers' `authorize()` calls.

---

## Getting started

```bash
# 1. Publish the RBAC layer, run the migration, and seed roles/permissions.
php artisan adminlte:scaffold rbac --seed

# 2. Register a user — the first account becomes the admin.
#    (Scaffold auth first if you haven't: php artisan adminlte:make-auth)

# 3. Visit the management UI.
#    /admin/users  and  /admin/roles
```

To protect your own routes or features, either add a `permission:` / `role:`
middleware, gate a menu item with `'can' => 'your-permission'`, or call
`$this->authorize('your-permission')` in a controller — then create that
permission in **Roles → edit** and assign it to a role.

---

## Customising

- **Add a permission:** create it in the Roles UI (or seeder), then reference its
  name anywhere a Gate ability is accepted.
- **Change the tables:** edit the published migration before running `migrate`.
- **Change admin behaviour:** the "admins pass everything" rule lives in
  `HasRoles::isAdmin()` and the `Gate::before` hook — both are in your app, edit
  freely.
- **Swap in a package** (e.g. spatie/laravel-permission): because the wiring is
  guarded by `class_exists`, you can delete the published RBAC classes and the
  package quietly stops registering its Gate hook and middleware aliases.

See also: [`scaffolding.md`](scaffolding.md) for the deep Laravel artifacts
(factories, form requests, policies, feature tests) and [`menu.md`](menu.md) for
the `can` filter.
