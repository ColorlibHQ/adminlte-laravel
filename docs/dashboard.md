# Data-driven Dashboard

The bundled demo dashboard mirrors the AdminLTE HTML index with static numbers.
The `dashboard` scaffold replaces those with **real aggregates** computed from
whatever sections you've installed.

```bash
php artisan adminlte:scaffold dashboard
```

Publishes a `DashboardController` + `resources/views/adminlte/dashboard/index.blade.php`
and the route `adminlte.dashboard` (`/admin/dashboard`), plus a `DashboardTest`.

## What it shows

| Widget | Source |
|--------|--------|
| Users stat box | `users` count |
| Projects stat box | `adminlte_projects` count |
| Unread messages stat box | `adminlte_messages` where `is_read = false` |
| Upcoming events stat box | `adminlte_events` where `start_at >= now()` |
| Projects-by-status bars | grouped count over `adminlte_projects.status` |
| Recent activity feed | latest `activity_log` rows |

Every metric is guarded by `Schema::hasTable()` / `hasColumn()`, so the dashboard
renders correctly whether you've scaffolded one section or all of them — counts
simply read **0** for sections you haven't installed. The stat boxes deep-link to
the relevant section when its route exists.

## Making it your home page

The scaffold registers `/admin/dashboard`. Point your root route at the same
controller to use it as the landing page:

```php
// routes/web.php
use App\Http\Controllers\AdminLte\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
```

Extend `DashboardController` with your own metrics — it's plain Eloquent/Query
Builder and fully yours to edit.
