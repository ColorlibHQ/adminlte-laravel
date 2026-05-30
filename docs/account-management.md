# Account Management

The `profile` scaffold is a complete, Jetstream-style account page — not just a
name/email form. It's tabbed: **Profile**, **Change password**, **Sessions**, and
a **Danger zone**.

```bash
php artisan adminlte:scaffold profile
php artisan migrate          # adds the nullable `avatar` column to users
php artisan storage:link     # so uploaded avatars are publicly served
```

## What it publishes

| Artifact | Destination |
|----------|-------------|
| `add_profile_fields_to_users_table` migration (avatar column) | `database/migrations/` |
| `UpdateProfileRequest`, `UpdatePasswordRequest` | `app/Http/Requests/AdminLte/` |
| `ProfileController` | `app/Http/Controllers/AdminLte/` |
| Tabbed account view | `resources/views/adminlte/profile/` |
| `ProfileTest` | `tests/Feature/AdminLte/` |
| Routes | `profile.*` in the managed `/admin` group |

Routes:

| Verb | URI | Name | Purpose |
|------|-----|------|---------|
| GET | `/admin/profile` | `adminlte.profile.show` | Account page |
| PUT | `/admin/profile` | `adminlte.profile.update` | Update name / email |
| PUT | `/admin/profile/password` | `adminlte.profile.password.update` | Change password |
| POST | `/admin/profile/avatar` | `adminlte.profile.avatar.update` | Upload avatar |
| PUT | `/admin/profile/other-sessions` | `adminlte.profile.sessions.logout-others` | Log out other devices |
| DELETE | `/admin/profile` | `adminlte.profile.destroy` | Delete account |

## Features

- **Profile** — name + email via `UpdateProfileRequest`. When the email changes
  and the `User` implements `MustVerifyEmail`, verification is re-triggered.
- **Avatar** — image upload (max 2 MB) to the `public` disk under `avatars/`. The
  path is set directly on the model, so you don't need to add `avatar` to the
  User `$fillable`. Requires `php artisan storage:link`.
- **Change password** — current-password check + confirmed new password
  (`UpdatePasswordRequest` uses the `current_password` rule and `Password::defaults()`).
- **Sessions** — lists the user's active sessions and offers
  "log out other devices" (`Auth::logoutOtherDevices`). Requires the **database
  session driver** (`SESSION_DRIVER=database` + a `sessions` table); with any
  other driver the tab shows a notice instead.
- **Danger zone** — password-confirmed account deletion (also removes the avatar
  file and logs the user out).

## Notes

- The account routes live in the auth-protected `/admin` group.
- See [`authentication.md`](authentication.md) for the related auth-hardening
  features (login throttling, email verification, password confirmation).
