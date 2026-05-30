# Notifications

The navbar bell and messages dropdowns are wired to **real Laravel data** — and
fall back to the config-driven demo arrays when the backing tables don't exist.
So the navbar is 1:1 with the AdminLTE HTML demo out of the box, and becomes real
the moment you scaffold notifications (and/or the mailbox).

## How the navbar is fed

`ColorlibHQ\AdminLte\Support\NavbarData` powers both dropdowns:

| Dropdown | Real source (when present) | Fallback |
|----------|----------------------------|----------|
| Bell (notifications) | `auth()->user()->unreadNotifications` (the `notifications` table) | `config('adminlte.navbar_notifications')` demo array |
| Messages | unread rows in `adminlte_messages` addressed to the current user (the scaffolded mailbox) | `config('adminlte.navbar_messages')` demo array |

Table-existence is checked once per request (memoized) and wrapped defensively,
so a missing table or a pre-migration request can never break rendering. The
bell badge shows the live unread count; the footer link points at the
notifications page when it exists.

> If you **published** the navbar partials into your app
> (`resources/views/vendor/adminlte/partials/navbar-notifications.blade.php`),
> re-publish them (or re-apply the change) to pick up the real-data wiring —
> published views override the package's.

## Scaffolding

```bash
php artisan adminlte:scaffold notifications --seed
```

Publishes:

| Artifact | Destination |
|----------|-------------|
| `create_notifications_table` migration | `database/migrations/` |
| `AdminLteDemoNotification` | `app/Notifications/` |
| `NotificationController` | `app/Http/Controllers/AdminLte/` |
| Index view | `resources/views/adminlte/notifications/` |
| `AdminLteNotificationsSeeder` | `database/seeders/` |
| `NotificationsTest` | `tests/Feature/AdminLte/` |
| Routes | `notifications.*` in the managed `/admin` group |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/notifications` | `adminlte.notifications.index` |
| PUT | `/admin/notifications/read-all` | `adminlte.notifications.read-all` |
| PUT | `/admin/notifications/{id}/read` | `adminlte.notifications.read` |
| DELETE | `/admin/notifications/{id}` | `adminlte.notifications.destroy` |

The index page lists all notifications with per-row mark-as-read / delete and a
"mark all as read" action.

## Sending notifications

`AdminLteDemoNotification` is a standard database notification — use it as a
template:

```php
use App\Notifications\AdminLteDemoNotification;

$user->notify(new AdminLteDemoNotification(
    title: 'Order shipped',
    message: 'Your order #1234 is on its way.',
    icon: 'bi bi-truck',
    url: route('orders.show', $order),
));
```

The `data` keys the navbar/index read are `title`, `message`, `icon`, and `url`.
Any notification with the `database` channel that includes those keys renders
correctly.

## Adding a menu item

```php
// config/adminlte.php
['text' => 'notifications', 'route' => 'adminlte.notifications.index', 'icon' => 'bi bi-bell'],
```
