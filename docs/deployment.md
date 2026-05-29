# Deploying the live preview

The AdminLTE 4 for Laravel preview is a **full Laravel application** (not a
static export), so it runs on a normal PHP host — e.g. an SSH preview server
behind Nginx + PHP-FPM. This guide stands up a browsable demo with every
feature working (charts, ⌘K palette, scaffolded sections, the in-app docs).

## Server requirements

| | |
|---|---|
| PHP | 8.3+ with `pdo`, `mbstring`, `openssl`, `ctype`, `fileinfo`, `bcmath` |
| Composer | 2.x |
| Node.js | 18+ (build step only) |
| Web server | Nginx or Apache → document root **must** be `public/` |
| Database | SQLite is fine for a demo; MySQL/Postgres for anything heavier |

## 1. Create the preview app

```bash
composer create-project laravel/laravel adminlte-preview
cd adminlte-preview
composer require colorlibhq/adminlte-laravel
```

## 2. Install AdminLTE + build assets

```bash
php artisan adminlte:install          # publishes config/stubs, npm deps, vendor files
# add the two entries to vite.config.js (see installation.md), then:
npm ci
npm run build
```

## 3. Scaffold the full demo

```bash
php artisan adminlte:make-auth                 # login/register/etc.
php artisan adminlte:scaffold --all --seed     # all DB-backed sections + demo data
php artisan migrate --force
```

## 4. Seed a demo user

The dashboard sits behind `auth`. Create a known demo account:

```bash
php artisan tinker --execute="\App\Models\User::firstOrCreate(
    ['email' => 'demo@adminlte.io'],
    ['name' => 'Demo User', 'password' => bcrypt('password')]
);"
```

## 5. Environment & optimisation

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laravel.adminlte.io
```

> The preview is hosted on a dedicated **subdomain** (`laravel.adminlte.io`),
> alongside the other Laravel template previews — the clean, recommended setup
> (no `ASSET_URL` or base-path rewriting needed). A sub-path mount is possible
> but fiddlier; see the note at the end of §7.

```bash
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R ug+rw storage bootstrap/cache
```

## 6. Make it publicly browsable (preview only)

A public demo should let visitors in without a password. Pick one:

### Option A — auto-login a demo user (recommended)

Add this to the **preview app's** `routes/web.php`, gated by an env flag so it
never ships to a real app:

```php
// routes/web.php  — PREVIEW ONLY
if (env('APP_DEMO', false)) {
    Route::get('/preview-login', function () {
        auth()->login(\App\Models\User::firstWhere('email', 'demo@adminlte.io'));
        return redirect('/');
    });
}
```

Set `APP_DEMO=true` in `.env`, then send visitors to `/preview-login` once (or
link it from your landing page). They land on the full dashboard with a real
session and can browse everything.

### Option B — show the demo credentials

Leave auth intact and add a banner to the login page (`resources/views/
vendor/adminlte/auth/login.blade.php` after `php artisan adminlte:install
--only=views`) telling visitors to log in with `demo@adminlte.io` /
`password`.

> Both options are for the **public preview** only. Never enable `APP_DEMO`
> or ship auto-login in a production application.

## 7. Nginx + PHP-FPM (subdomain — recommended)

Host on the dedicated subdomain `laravel.adminlte.io`, alongside the other
Laravel template previews. Point its document root at the app's `public/`:

```nginx
server {
    listen 443 ssl http2;
    server_name laravel.adminlte.io;
    root /var/www/laravel.adminlte.io/public;

    # ssl_certificate ... (Let's Encrypt / your CA)

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* { deny all; }
}
```

Add the DNS record (`laravel` A/CNAME → the preview server) and issue a TLS
cert (`certbot --nginx -d laravel.adminlte.io`). That's the whole setup — no
`ASSET_URL` or path rewriting required.

> **Sub-path instead?** Mounting under `adminlte.io/themes/laravel/` is
> possible (Nginx `alias` + `ASSET_URL` set to the full sub-path + a rewrite to
> `index.php`), but it's noticeably more fragile for a Laravel app. Prefer the
> subdomain unless you can't add DNS records.

## 8. Quick alternative — `php artisan serve` behind a proxy

For a throwaway preview you can skip PHP-FPM and run the built-in server under
a process manager, proxied by Nginx:

```bash
# supervisor / systemd unit
php artisan serve --host=127.0.0.1 --port=8000
```

```nginx
location / { proxy_pass http://127.0.0.1:8000; proxy_set_header Host $host; }
```

## Other hosting options

### Laravel Forge / managed hosting

Point Forge (or Ploi/RunCloud) at the repo and use this deploy script — it
covers the build, migrations, and caching in one pass:

```bash
composer install --optimize-autoloader --no-dev
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Add `demo@adminlte.io` + `APP_DEMO=true` (step 4 & 6) to the environment so the
public demo works, and set the site's web root to `public/`.

### Docker

```dockerfile
FROM php:8.3-fpm AS app
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y nodejs npm \
    && docker-php-ext-install pdo pdo_mysql bcmath
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build \
    && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Serve `public/` with Nginx (see §7) in front of the PHP-FPM container.

## Updating the preview

```bash
git pull            # or composer update colorlibhq/adminlte-laravel
composer install --no-dev -o
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Checklist

- [ ] `public/` is the web root
- [ ] `npm run build` ran (the `build/` manifest exists)
- [ ] `public/vendor/*` plugin files present (`adminlte:install` copies them)
- [ ] `APP_KEY` set, `APP_DEBUG=false`
- [ ] demo user seeded; `APP_DEMO`/`/preview-login` wired if you want a public demo
- [ ] `storage/` and `bootstrap/cache/` writable
