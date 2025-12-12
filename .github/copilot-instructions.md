### Copilot instructions for this repository

This project is a minimal Laravel application skeleton. The file layout, composer scripts, and Vite-based frontend are the main places to look when making changes.

- **Big picture**: Laravel monolith (PHP backend + Vite frontend).
  - Backend entry: `public/index.php` -> Laravel `artisan` commands.
  - HTTP routes are declared in `routes/web.php` (currently returns the `welcome` view).
  - Controllers live under `app/Http/Controllers` (see `Controller.php`).
  - Eloquent models live under `app/Models` (example: `app/Models/User.php`).
  - Database schema lives in `database/migrations` and uses Laravel migrations.

- **Developer workflows (explicit commands to run)**:
  - Install and full setup: run `composer run-script setup` (see `composer.json` -> `scripts.setup`).
  - Start dev environment (backend + workers + vite): `composer run-script dev` (uses `npx concurrently`).
  - Frontend dev: `npm run dev` (uses Vite). Build frontend: `npm run build`.
  - Tests: `composer run-script test` or `php artisan test`. Tests use an in-memory sqlite DB (`phpunit.xml`).

- **Project-specific patterns and gotchas**:
  - The project uses the Laravel 12 skeleton and modern PHP (requires PHP ^8.2). Check `composer.json`.
  - `app/Models/User.php` defines `casts()` as a protected method returning an array (note: inspect model definitions for either `$casts` property or `casts()` method).
  - `composer.json` has composite scripts (`setup`, `dev`) that run migrations, `npm install`, and Vite; prefer using those for consistent environment setup.
  - PHPUnit is configured to run with many env overrides (see `phpunit.xml`) — tests expect sqlite in-memory by default.

- **Integration points & external tools**:
  - Vite + `laravel-vite-plugin` for assets (`resources/js`, `resources/css`). See `package.json` and `vite.config.js`.
  - Background processes referenced in `composer dev`: `php artisan queue:listen`, `php artisan pail` (a logging helper), and `php artisan serve`.
  - Optional Docker/Sail support via `laravel/sail` in `require-dev`.

- **When editing code**:
  - Prefer touching `routes/*`, `app/Http/Controllers/*`, `app/Models/*`, and `resources/views/*` for typical feature work.
  - If you change database structure, add a new migration in `database/migrations` rather than editing existing migrations.
  - Update `database/factories` and `database/seeders` for test data when adding models.

- **Examples (use these as templates)**:
  - Add a new route: modify `routes/web.php` and create a controller under `app/Http/Controllers`.
  - New model: create `app/Models/MyModel.php`, migration in `database/migrations`, and a factory in `database/factories`.

- **Where to look for more context**:
  - `composer.json` — project scripts and PHP dependencies.
  - `package.json` and `vite.config.js` — frontend build integration.
  - `phpunit.xml` — test environment expectations.
  - `database/migrations`, `database/factories`, `database/seeders` — DB lifecycle and test data.

If anything in this file is unclear or you want more detail (examples, common PR templates, or coding conventions), tell me which area to expand and I will iterate.
