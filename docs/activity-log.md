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

### Logging your own events

```php
use ColorlibHQ\AdminLte\Support\ActivityLogger;

ActivityLogger::log('order.refunded', 'Refunded order #1234', ['amount' => 4999], $order);
```

### Securing the viewer

The viewer is auth-only by default. Restrict it to admins by gating the route
with `permission:view-activity` (see [`authorization.md`](authorization.md)) and
gating its menu item with `'can' => 'view-activity'`.

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
