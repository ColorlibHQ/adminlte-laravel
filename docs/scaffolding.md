# Scaffolding Sections

The `adminlte:scaffold` command publishes complete, working sections into your
Laravel app — migrations, Eloquent models, controllers, seeders, Blade views, and
routes — driven by a declarative manifest baked into `ScaffoldCommand`.

## Usage

```text
adminlte:scaffold [section] [--all] [--force] [--seed]
```

| Argument / Option | Description |
|-------------------|-------------|
| `section` | One of the 18 section names (see below). Omit it (without `--all`) for an interactive multi-select prompt. |
| `--all` | Scaffold all 18 sections. |
| `--force` | Overwrite existing files instead of skipping them. |
| `--seed` | After publishing, run `php artisan migrate --force` then `db:seed` for each scaffolded section's seeder. |

Behavior:

- Passing an unknown `section` aborts with an error listing the valid names.
- With no `section` and no `--all`, you get a multi-select picker.
- Files that already exist are skipped (printed as `exists`) unless `--force` is used.
- Route registration is idempotent — a section's routes are added once and skipped on re-runs.

## Available sections

| Section | Description |
|---------|-------------|
| `dashboard` | Data-driven dashboard with real stats — see [`dashboard.md`](dashboard.md) |
| `mailbox` | Messages mailbox with inbox/read/compose |
| `chat` | Conversations and chat messaging |
| `kanban` | Kanban boards with drag-to-reorder cards |
| `calendar` | Event calendar with FullCalendar |
| `projects` | Project management CRUD |
| `file-manager` | File browser using Laravel Storage |
| `profile` | User profile page |
| `settings` | User settings page |
| `invoice` | Invoice generator |
| `pricing` | Pricing page |
| `faq` | FAQ accordion |
| `notifications` | Database notifications + navbar bell wiring + page — see [`notifications.md`](notifications.md) |
| `api` | Sanctum personal access tokens + management UI — see [`api.md`](api.md) |
| `realtime` | Broadcast event + Echo listeners for live chat/notifications — see [`realtime.md`](realtime.md) |
| `impersonation` | "Log in as" another user (RBAC-gated) — see [`activity-log.md`](activity-log.md) |
| `activity-log` | Activity/audit log + `LogsActivity` trait + auto auth-event logging — see [`activity-log.md`](activity-log.md) |
| `rbac` | Roles & permissions, management UI, `HasRoles` on `User` — see [`authorization.md`](authorization.md) |

## Where files are published

| Artifact | Destination |
|----------|-------------|
| Migrations | `database/migrations/{timestamp}_{name}.php` (timestamps staggered for deterministic order) |
| Models | `app/Models/{Model}.php` |
| Controllers | `app/Http/Controllers/AdminLte/{Controller}.php` |
| Form Requests | `app/Http/Requests/AdminLte/{Request}.php` |
| Policies | `app/Policies/{Model}Policy.php` |
| Model factories | `database/factories/{Model}Factory.php` |
| Notifications | `app/Notifications/{Notification}.php` |
| Broadcast events | `app/Events/{Event}.php` |
| Model concerns (traits) | `app/Models/Concerns/{Trait}.php` |
| Feature tests | `tests/Feature/AdminLte/{Section}Test.php` |
| Seeders | `database/seeders/{Seeder}.php` |
| Views | `resources/views/adminlte/{section}/` |
| Routes | appended into a managed group in `routes/web.php` (see below) |

---

## Deep Laravel artifacts

The DB-backed sections don't just publish a controller and a view — they
generate the full set of building blocks a Laravel developer expects, so the
scaffolded code is production-shaped from day one rather than a throwaway demo.

| Artifact | What it gives you |
|----------|-------------------|
| **Model factories** | Every scaffolded model uses the `HasFactory` trait and ships a matching factory in `database/factories/`, so you can `Message::factory()->count(10)->create()` in seeders and tests immediately. |
| **Form Requests** | Write operations are validated through dedicated `Store*` / `Update*` Form Request classes (`$request->validated()`), keeping validation rules out of the controller. |
| **Policies** | Each DB-backed model gets a Policy with `viewAny` / `view` / `create` / `update` / `delete` methods (ownership-aware where relevant). Controllers call `$this->authorize(...)` on every action. |
| **Feature tests** | Each section ships a `tests/Feature/AdminLte/` test that asserts guests are redirected, authenticated users can view, and CRUD + authorization behave — runnable with `php artisan test` right after scaffolding. |

The Policies are registered automatically by the package (guarded by
`class_exists`), and authorization keys resolve through the optional RBAC layer.
See [`authorization.md`](authorization.md) for roles, permissions, and how the
menu and Policies tie into Gate.

---

## Section manifest

The following tables list exactly what each section publishes, per the manifest in
`ScaffoldCommand`.

### `mailbox`

| Type | Items |
|------|-------|
| Migrations | `create_adminlte_messages_table` |
| Models | `Message` |
| Controllers | `MailboxController` |
| Seeders | `AdminLteMailboxSeeder` |
| Views | `mailbox/` (inbox, read, compose) |
| Routes | `mailbox` |
| Seeder run on `--seed` | `AdminLteMailboxSeeder` |

Routes (`adminlte.` prefix):

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/mailbox` | `adminlte.mailbox.index` |
| GET | `/admin/mailbox/compose` | `adminlte.mailbox.create` |
| POST | `/admin/mailbox` | `adminlte.mailbox.store` |
| GET | `/admin/mailbox/{message}` | `adminlte.mailbox.show` |
| DELETE | `/admin/mailbox/{message}` | `adminlte.mailbox.destroy` |

### `chat`

| Type | Items |
|------|-------|
| Migrations | `create_adminlte_conversations_table` (creates 3 tables) |
| Models | `Conversation`, `ChatMessage` |
| Controllers | `ChatController` |
| Seeders | `AdminLteChatSeeder` |
| Views | `chat/` |
| Routes | `chat` |
| Seeder run on `--seed` | `AdminLteChatSeeder` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/chat` | `adminlte.chat.index` |
| GET | `/admin/chat/{conversation}` | `adminlte.chat.show` |
| POST | `/admin/chat/{conversation}` | `adminlte.chat.store` |

### `kanban`

| Type | Items |
|------|-------|
| Migrations | `create_adminlte_kanban_tables` (creates 4 tables) |
| Models | `KanbanBoard`, `KanbanLane`, `KanbanCard` |
| Controllers | `KanbanController` |
| Seeders | `AdminLteKanbanSeeder` |
| Views | `kanban/` |
| Routes | `kanban` |
| Seeder run on `--seed` | `AdminLteKanbanSeeder` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/kanban` | `adminlte.kanban.index` |
| POST | `/admin/kanban/cards` | `adminlte.kanban.cards.store` |
| POST | `/admin/kanban/reorder` | `adminlte.kanban.reorder` |

### `calendar`

| Type | Items |
|------|-------|
| Migrations | `create_adminlte_events_table` |
| Models | `Event` |
| Controllers | `CalendarController` |
| Seeders | `AdminLteCalendarSeeder` |
| Views | `calendar/` (FullCalendar) |
| Routes | `calendar` |
| Seeder run on `--seed` | `AdminLteCalendarSeeder` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/calendar` | `adminlte.calendar.index` |
| GET | `/admin/calendar/feed` | `adminlte.calendar.feed` |
| POST | `/admin/calendar` | `adminlte.calendar.store` |
| PUT | `/admin/calendar/{event}` | `adminlte.calendar.update` |
| DELETE | `/admin/calendar/{event}` | `adminlte.calendar.destroy` |

### `projects`

| Type | Items |
|------|-------|
| Migrations | `create_adminlte_projects_table` |
| Models | `Project` |
| Controllers | `ProjectsController` |
| Seeders | `AdminLteProjectsSeeder` |
| Views | `projects/` |
| Routes | `projects` |
| Seeder run on `--seed` | `AdminLteProjectsSeeder` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/projects` | `adminlte.projects.index` |
| POST | `/admin/projects` | `adminlte.projects.store` |
| PUT | `/admin/projects/{project}` | `adminlte.projects.update` |
| DELETE | `/admin/projects/{project}` | `adminlte.projects.destroy` |

### `file-manager`

No database. Browses files via Laravel's `Storage`.

| Type | Items |
|------|-------|
| Controllers | `FileManagerController` |
| Views | `file-manager/` |
| Routes | `file-manager` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/file-manager` | `adminlte.file-manager.index` |
| POST | `/admin/file-manager/upload` | `adminlte.file-manager.upload` |
| DELETE | `/admin/file-manager` | `adminlte.file-manager.destroy` |

### `profile`

No database (operates on the authenticated user).

| Type | Items |
|------|-------|
| Controllers | `ProfileController` |
| Views | `profile/` |
| Routes | `profile` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/profile` | `adminlte.profile.show` |
| PUT | `/admin/profile` | `adminlte.profile.update` |

### `settings`

No database.

| Type | Items |
|------|-------|
| Controllers | `SettingsController` |
| Views | `settings/` |
| Routes | `settings` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/settings` | `adminlte.settings.edit` |
| PUT | `/admin/settings` | `adminlte.settings.update` |

### `invoice`

No database.

| Type | Items |
|------|-------|
| Controllers | `InvoiceController` |
| Views | `invoice/` |
| Routes | `invoice` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/invoice` | `adminlte.invoice.show` |

### `pricing`

View-only (no controller, no DB). Uses `Route::view`.

| Type | Items |
|------|-------|
| Views | `pricing/` |
| Routes | `pricing` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/pricing` | `adminlte.pricing.index` |

### `faq`

View-only (no controller, no DB). Uses `Route::view`.

| Type | Items |
|------|-------|
| Views | `faq/` |
| Routes | `faq` |

Routes:

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/faq` | `adminlte.faq.index` |

---

## Database tables

The five DB-backed sections create the following tables.

### Mailbox — `adminlte_messages`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `from_user_id` | FK → `users.id` | cascade on delete |
| `to_user_id` | FK → `users.id` | cascade on delete |
| `subject` | string | |
| `body` | text | |
| `is_read` | boolean | default `false` |
| `is_starred` | boolean | default `false` |
| `created_at` / `updated_at` | timestamps | |

### Chat — three tables

`adminlte_conversations`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `name` | string | nullable |
| timestamps | | |

`adminlte_conversation_user` (pivot)

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `conversation_id` | FK → `adminlte_conversations.id` | cascade on delete |
| `user_id` | FK → `users.id` | cascade on delete |
| timestamps | | |
| unique | `(conversation_id, user_id)` | |

`adminlte_chat_messages`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `conversation_id` | FK → `adminlte_conversations.id` | cascade on delete |
| `user_id` | FK → `users.id` | cascade on delete |
| `body` | text | |
| timestamps | | |

### Kanban — four tables

`adminlte_kanban_boards`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `name` | string | |
| timestamps | | |

`adminlte_kanban_lanes`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `board_id` | FK → `adminlte_kanban_boards.id` | cascade on delete |
| `name` | string | |
| `position` | unsigned int | default `0` |
| timestamps | | |

`adminlte_kanban_cards`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `lane_id` | FK → `adminlte_kanban_lanes.id` | cascade on delete |
| `title` | string | |
| `description` | text | nullable |
| `color` | string | default `primary` |
| `position` | unsigned int | default `0` |
| timestamps | | |

`adminlte_kanban_card_user` (pivot)

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `card_id` | FK → `adminlte_kanban_cards.id` | cascade on delete |
| `user_id` | FK → `users.id` | cascade on delete |
| unique | `(card_id, user_id)` | |

### Calendar — `adminlte_events`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `title` | string | |
| `start_at` | datetime | |
| `end_at` | datetime | nullable |
| `all_day` | boolean | default `false` |
| `color` | string | default `#0d6efd` |
| timestamps | | |

### Projects — `adminlte_projects`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint PK | |
| `name` | string | |
| `description` | text | nullable |
| `status` | enum | `planning`, `active`, `on_hold`, `completed` (default `planning`) |
| `progress` | unsigned tiny int | default `0` |
| `due_date` | date | nullable |
| timestamps | | |

---

## Route group injected into `routes/web.php`

The scaffolder appends section routes into a **managed block** in
`routes/web.php`. The block is created once and reused for subsequent sections.

The generated group:

```php
// AdminLTE scaffold routes
Route::middleware(['web', 'auth'])->prefix('admin')->name('adminlte.')->group(function () {
    // [adminlte:mailbox]
    // ... the section's route lines ...
});
```

Key points:

- Middleware: `web` + `auth` — **all scaffolded pages require authentication**.
- URI prefix: `/admin`.
- Route-name prefix: `adminlte.` (so a section route `mailbox.index` becomes
  `adminlte.mailbox.index`).
- Each section is wrapped behind a `// [adminlte:{section}]` marker. If that marker
  is already present, the section's routes are not added again (idempotent).
- New sections are inserted right after the opening of the managed group; if the
  managed group doesn't exist yet, it's created at the end of the file.

If `routes/web.php` is missing, route registration is skipped with a warning.

---

## Seeders and `--seed`

Each DB-backed section ships a demo-data seeder:

| Section | Seeder class | Published to |
|---------|--------------|--------------|
| mailbox | `AdminLteMailboxSeeder` | `database/seeders/` |
| chat | `AdminLteChatSeeder` | `database/seeders/` |
| kanban | `AdminLteKanbanSeeder` | `database/seeders/` |
| calendar | `AdminLteCalendarSeeder` | `database/seeders/` |
| projects | `AdminLteProjectsSeeder` | `database/seeders/` |

When `--seed` is passed, for each scaffolded section that defines a seeder the
command runs:

```bash
php artisan migrate --force
php artisan db:seed --class={Seeder} --force
```

(View-only sections — file-manager, profile, settings, invoice, pricing, faq —
have no seeder and are skipped by `--seed`.)

---

## Getting started example

Scaffold the mailbox, create its table, seed demo data, and view it:

```bash
# 1. Scaffold the mailbox section (publishes migration, model, controller,
#    seeder, views, and routes) and run migrate + seed in one shot.
php artisan adminlte:scaffold mailbox --seed

# If you prefer to do it in steps:
php artisan adminlte:scaffold mailbox
php artisan migrate
php artisan db:seed --class=AdminLteMailboxSeeder
```

Then:

1. Add a sidebar menu item in `config/adminlte.php` pointing at the new route:

   ```php
   ['text' => 'Mailbox', 'route' => 'adminlte.mailbox.index', 'icon' => 'bi bi-envelope'],
   ```

2. Log in (the `/admin` group is auth-protected — scaffold auth first with
   `php artisan adminlte:make-auth` if needed; see [`authentication.md`](authentication.md)).

3. Visit **`/admin/mailbox`**.
