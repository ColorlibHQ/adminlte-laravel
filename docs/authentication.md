# Authentication

The `adminlte:make-auth` command scaffolds authentication for an AdminLTE 4 app.
It supports three modes via the `--type` option: **plain** (self-contained
controllers + routes), **breeze**, and **fortify** (integration guidance for those
starter kits). The AdminLTE auth views ship with the package regardless of mode.

## Signature

```text
adminlte:make-auth
    {--type=plain : Auth type (plain, breeze, fortify)}
    {--force : Overwrite existing files}
```

| Option | Description |
|--------|-------------|
| `--type=plain` (default) | Publish auth controllers and register their routes. |
| `--type=breeze` | Print Laravel Breeze integration steps. |
| `--type=fortify` | Print Laravel Fortify integration steps. |
| `--force` | Overwrite existing controller files (plain mode). |

An invalid `--type` value fails the command with:
`Invalid auth type: {type}. Use plain, breeze, or fortify.`

---

## Plain mode (`--type=plain`)

This is the default. It publishes four self-contained auth controllers and appends
the auth route group to `routes/web.php`.

### Controllers published

Each is copied to `app/Http/Controllers/Auth/`:

| Controller | Responsibility |
|------------|----------------|
| `LoginController` | Show login form, log in, log out |
| `RegisterController` | Show registration form, register a user |
| `ForgotPasswordController` | Show "forgot password" form, send reset link |
| `ResetPasswordController` | Show reset form, reset the password |

Existing files are skipped (printed as `exists`) unless `--force` is used.

### Routes registered

The auth routes are appended to `routes/web.php` from the package's
`routes/auth.php.stub`. Registration is idempotent — if the marker
`// AdminLTE authentication routes` is already present, nothing is added.

Guest routes (wrapped in `Route::middleware('guest')`):

| Verb | URI | Name | Action |
|------|-----|------|--------|
| GET | `login` | `login` | `LoginController@showLoginForm` |
| POST | `login` | — | `LoginController@login` |
| GET | `register` | `register` | `RegisterController@showRegistrationForm` |
| POST | `register` | — | `RegisterController@register` |
| GET | `forgot-password` | `password.request` | `ForgotPasswordController@showLinkRequestForm` |
| POST | `forgot-password` | `password.email` | `ForgotPasswordController@sendResetLinkEmail` |
| GET | `reset-password/{token}` | `password.reset` | `ResetPasswordController@showResetForm` |
| POST | `reset-password` | `password.update` | `ResetPasswordController@reset` |

Authenticated route:

| Verb | URI | Name | Action | Middleware |
|------|-----|------|--------|------------|
| POST | `logout` | `logout` | `LoginController@logout` | `auth` |

### Next steps printed

```text
1. Auth views ship with the package (adminlte::auth.*) — already wired.
2. Ensure your User model and the password_reset_tokens table exist.
3. Visit /login to sign in.
```

> The `password_reset_tokens` table is part of Laravel's default migrations; make
> sure it has been migrated before using the forgot/reset password flow.

### Example

```bash
# Scaffold plain auth (controllers + routes)
php artisan adminlte:make-auth

# Re-scaffold, overwriting the controllers
php artisan adminlte:make-auth --type=plain --force
```

---

## Auth views (shipped with the package)

The following Blade views ship in the package and are referenced via the
`adminlte::` namespace. They are used by plain mode automatically, and can be
wired into Breeze/Fortify. To customize them, publish with
`php artisan adminlte:install --only=views` (they land in
`resources/views/vendor/adminlte/auth/`).

| View name | File |
|-----------|------|
| `adminlte::auth.login` | `auth/login.blade.php` |
| `adminlte::auth.register` | `auth/register.blade.php` |
| `adminlte::auth.login-v2` | `auth/login-v2.blade.php` |
| `adminlte::auth.register-v2` | `auth/register-v2.blade.php` |
| `adminlte::auth.lockscreen` | `auth/lockscreen.blade.php` |
| `adminlte::auth.passwords.email` | `auth/passwords/email.blade.php` |
| `adminlte::auth.passwords.reset` | `auth/passwords/reset.blade.php` |

(`auth/auth-master.blade.php` is the shared layout these views extend.)

---

## Breeze mode (`--type=breeze`)

No files are published — the command prints integration guidance:

1. Install Breeze:

   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   ```

2. Re-publish AdminLTE views so Breeze uses them:

   ```bash
   php artisan adminlte:install --only=views
   ```

3. Breeze already registers login/register/password routes — no extra routes needed.

```bash
php artisan adminlte:make-auth --type=breeze
```

---

## Fortify mode (`--type=fortify`)

No files are published — the command prints integration guidance:

1. Install Fortify:

   ```bash
   composer require laravel/fortify
   ```

2. In `FortifyServiceProvider`, point the views at AdminLTE:

   ```php
   Fortify::loginView(fn () => view('adminlte::auth.login'));
   Fortify::registerView(fn () => view('adminlte::auth.register'));
   ```

```bash
php artisan adminlte:make-auth --type=fortify
```

---

## Example flow (plain auth)

```bash
# 1. Install the package scaffolding (config, assets, npm deps)
php artisan adminlte:install

# 2. Scaffold plain authentication (controllers + routes)
php artisan adminlte:make-auth

# 3. Make sure Laravel's default auth tables exist (users, password_reset_tokens)
php artisan migrate

# 4. Build the frontend
npm run dev   # or: npm run build
```

Then:

1. Visit **`/register`** to create an account, or **`/login`** to sign in.
2. Use **`/forgot-password`** to request a reset link and **`/reset-password/{token}`** to set a new password.
3. Once authenticated you can reach the auth-protected `/admin` scaffolded
   sections (see [`scaffolding.md`](scaffolding.md)).

> Because the scaffolded `/admin/*` routes use the `auth` middleware, having a
> working login flow is a prerequisite for viewing scaffolded sections.

---

## Hardening (plain auth)

`adminlte:make-auth` (plain mode) scaffolds a security-hardened stack out of the
box — no extra packages required.

### Login rate limiting

`LoginController` throttles failed attempts (5 per `email` + IP) and throws the
standard `auth.throttle` lockout message. On success the limiter is cleared and
the session is regenerated.

### Email verification

The command publishes `EmailVerificationController` (notice / verify / resend),
registers the verification routes (`verification.notice`; `verification.verify`
behind `signed` + `throttle:6,1`; `verification.send` behind `throttle:6,1`), and
ships the `adminlte::auth.verify-email` view. It also makes your `User` model
implement `MustVerifyEmail` (uncommenting Laravel's default import; idempotent).

Protect routes that require a verified address with the `verified` middleware:

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // ...
});
```

### Password confirmation

`ConfirmablePasswordController` + the `adminlte::auth.confirm-password` view + the
`password.confirm` route let you guard sensitive actions. Apply the
`password.confirm` middleware to anything that should re-prompt for the password:

```php
Route::get('billing', BillingController::class)->middleware('password.confirm');
```

> **Two-factor authentication.** For TOTP-based 2FA, use the Fortify integration
> (`adminlte:make-auth --type=fortify`) and point Fortify's 2FA challenge view at
> AdminLTE — Fortify provides the canonical, well-tested 2FA implementation
> rather than hand-rolled crypto.

### Account management

The `profile` scaffold provides a full account page (avatar upload, change
password, active sessions, delete account). See
[`account-management.md`](account-management.md).
