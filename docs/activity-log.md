# Activity Log & Impersonation

Two admin-grade features that the HTML template can't provide because they need a
backend: a **database activity/audit log** and **user impersonation** ("log in
as"). Both are dependency-free.

---

## Activity log

```bash
php artisan adminlte:scaffold activity-log
php artisan migrate
```

Publishes:

| Artifact | Destination |
|----------|-------------|
| `create_activity_log_table` migration | `database/migrations/` |
| `Activity` model | `app/Models/` |
| `LogsActivity` trait | `app/Models/Concerns/` |
| `ActivityController` viewer | `app/Http/Controllers/AdminLte/` |
| Index view | `resources/views/adminlte/activity/` |
| `ActivityLogTest` | `tests/Feature/AdminLte/` |
| Route | `adminlte.activity.index` (`/admin/activity`) |

### Automatic auth-event logging

The package registers listeners for `Login`, `Logout`, and `Failed` auth events
that write `auth.login` / `auth.logout` / `auth.failed` rows. This happens
automatically once the `activity_log` table exists — no app provider changes.
The writer (`ColorlibHQ\AdminLte\Support\ActivityLogger`) no-ops when the table
is absent, so it's always safe.

### Logging model changes

Add the published trait to any Eloquent model to record create / update / delete:

```php
use App\Models\Concerns\LogsActivity;

class Project extends Model
{
    use LogsActivity;
}
```

Updates record the changed attributes in the row's `properties` JSON.

### What is never logged

`ActivityLogger` removes secrets from `properties` before writing a row, so adding
the trait to `User` is safe:

- the subject model's `$hidden` attributes (on `User`: `password`,
  `remember_token`, `two_factor_secret`, `two_factor_recovery_codes`, ...);
- any key matching `password`, `secret`, `token`, `api_key` / `apikey`,
  `private_key` or `recovery_codes` (case-insensitive, at any nesting depth);
- any extra keys you list in `config('adminlte.activity_log.redact')`.

Upgrading from 1.6.1 or earlier: `php artisan migrate` runs the package's
`redact_secrets_in_adminlte_activity_log` migration, which removes such values
from rows that earlier versions already stored (other data in each row is kept).

### Logging your own events

```php
use ColorlibHQ\AdminLte\Support\ActivityLogger;

ActivityLogger::log('order.refunded', 'Refunded order #1234', ['amount' => 4999], $order);
```

### Securing the viewer

The viewer lists every user's sign-ins, IP addresses and recorded changes, so
`ActivityController` calls `Gate::authorize('view-activity')`. The package
defines a default `view-activity` gate:

- **With RBAC** (`adminlte:scaffold rbac`): admins, and roles you give the
  `view-activity` permission (seeded by `AdminLteRbacSeeder`, assigned to
  `admin` only). Everyone else gets a 403.
- **Without RBAC:** any signed-in user, because there are no roles to tell
  users apart.

To change either rule, define your own gate in your `AppServiceProvider` — it
takes precedence:

```php
Gate::define('view-activity', fn (User $user) => $user->is_admin);
```

Gate the menu item with `'can' => 'view-activity'` so users who can't open the
page don't see it. If you scaffolded the viewer with 1.6.1 or earlier, add the
`Gate::authorize('view-activity');` line to your published
`app/Http/Controllers/AdminLte/ActivityController.php` (or re-publish it with
`--force`).

---

## Impersonation

```bash
php artisan adminlte:scaffold impersonation
```

Publishes `ImpersonationController` and the `impersonate.*` routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/impersonate/{user}` | `adminlte.impersonate.start` |
| GET | `/admin/impersonate-leave` | `adminlte.impersonate.stop` |

Behaviour:

- **Authorization** — `start` calls `$this->authorize('impersonate')`. Admins
  pass via the package's `Gate::before` (see [`authorization.md`](authorization.md));
  grant an `impersonate` permission to a role for non-admins. Without RBAC the
  ability is denied by default, so impersonation effectively requires RBAC.
- **"Log in as"** — the RBAC users table (`/admin/users`) shows a "Log in as"
  action per user (guarded by `Route::has`), so impersonation and RBAC compose.
- **Revert banner** — while impersonating, a banner appears on every page with a
  "Leave impersonation" link that returns you to your original account. (Shipped
  in the package layout; re-publish your `master.blade.php` if you've published
  views.)
- **Audited** — start/stop are written to the activity log when it's installed.

> Impersonation pairs naturally with [`rbac`](authorization.md) (you impersonate
> from the Users management table) — scaffold both for the full experience.
