# Changelog

All notable changes to `colorlibhq/adminlte-laravel` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Three more Bootstrap-native form components (no external JS required):
  `<x-adminlte-input-switch>`, `<x-adminlte-input-color>`, `<x-adminlte-input-file>`.
- GitHub Actions CI: Pint + PHPUnit across PHP 8.3 / 8.4 on Laravel 13.

## [0.1.0] - 2026-05-28

### Added

- Initial public release. AdminLTE 4 integration for Laravel 13 / PHP 8.3+.
- Config-driven sidebar menu (`config/adminlte.php`) with a filter pipeline:
  gate authorization (`can`), href resolution (route/url), automatic
  active-state, and navbar-search normalization. Unlimited treeview nesting,
  badges, icons, section headers.
- Blade layouts: `master` + `page` (extend with `@extends('adminlte::page')`),
  plus navbar, sidebar, footer, color-mode toggle, and user-menu partials.
- Auth views: login, register, forgot-password, reset-password on a dedicated
  auth layout, wired to Laravel's conventional named routes.
- 11 Blade components: card, small-box, info-box, alert, callout, progress,
  input, textarea, select, button, modal. Form components surface validation
  errors and repopulate `old()` input automatically.
- Artisan commands: `adminlte:install` and `adminlte:status`.
- Vite-first asset strategy — pulls `admin-lte` + `bootstrap` from npm and
  imports through the app's Vite pipeline (no precompiled assets shipped).
