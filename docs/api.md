# API Tokens (Sanctum)

A personal-access-token management UI backed by Laravel Sanctum — create named
tokens, see when they were last used, and revoke them.

## Setup

Sanctum is a peer dependency. Install it first (Laravel 11+):

```bash
php artisan install:api          # pulls in Sanctum + personal_access_tokens migration + routes/api.php
php artisan adminlte:scaffold api
php artisan migrate
```

`adminlte:scaffold api` publishes:

| Artifact | Destination |
|----------|-------------|
| `ApiTokenController` | `app/Http/Controllers/AdminLte/` |
| Token management view | `resources/views/adminlte/api-tokens/` |
| `ApiTokenTest` | `tests/Feature/AdminLte/` |
| Routes | `api-tokens.*` in the managed `/admin` group |

It also:

- Wires Sanctum's **`HasApiTokens` trait into your `User` model** (idempotent;
  only runs once Sanctum is detected — guarded with `trait_exists`).
- Appends an example **`auth:sanctum`** endpoint to `routes/api.php`:

  ```php
  Route::middleware('auth:sanctum')->get('/user', fn (Request $r) => $r->user());
  ```

## Routes

| Verb | URI | Name |
|------|-----|------|
| GET | `/admin/api-tokens` | `adminlte.api-tokens.index` |
| POST | `/admin/api-tokens` | `adminlte.api-tokens.store` |
| DELETE | `/admin/api-tokens/{token}` | `adminlte.api-tokens.destroy` |

The page lists existing tokens (name + last used + revoke) and a create form. The
**plaintext token is shown exactly once** after creation.

## Using a token

```bash
curl -H "Authorization: Bearer {token}" -H "Accept: application/json" \
     https://your-app.test/api/user
```

Scope tokens with abilities by extending the store form / controller
(`$user->createToken($name, ['posts:read'])`) and checking `$user->tokenCan(...)`.

## Menu item

```php
['text' => 'api_tokens', 'route' => 'adminlte.api-tokens.index', 'icon' => 'bi bi-key'],
```
