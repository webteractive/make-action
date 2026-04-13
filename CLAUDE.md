# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Laravel package (`webteractive/make-action`) that provides `php artisan make:action {name}` to scaffold Action classes in `app/Actions/`. Built on Spatie's `laravel-package-tools`.

## Commands

```bash
composer test        # Run tests (Pest)
composer format      # Fix code style (Pint, Laravel preset)
composer analyse     # Static analysis (PHPStan, level 5)
```

Run a single test:
```bash
vendor/bin/pest --filter="test name here"
```

## Architecture

- **`src/MakeActionServiceProvider.php`** — Registers config and the artisan command via Spatie's `Package` API
- **`src/Commands/MakeActionCommand.php`** — The `make:action` command. Accepts optional name argument, falls back to Laravel Prompts for interactive input. Injects `Illuminate\Filesystem\Filesystem` (not the `File` facade). Reads `stubs/action.stub`, replaces `{{ namespace }}`, `{{ class }}`, `{{ method }}` placeholders via `str_replace`, writes to `app/Actions/`
- **`config/make-action.php`** — Single config option: `method_name` (default: `handle`)
- **`stubs/action.stub`** — Template with `{{ namespace }}`, `{{ class }}`, `{{ method }}` placeholders. If adding new placeholders, update both the stub and the `str_replace` call in `MakeActionCommand::handle()`
- **`resources/boost/guidelines/`** — AI guidelines for Laravel Boost integration (`core.blade.php` for general usage, `filament.blade.php` for Filament patterns). Tests assert specific section headings exist (e.g. `## make:action Command`, `### Features`), so renaming sections requires updating `BoostGuidelinesTest`

## Compatibility

- PHP 8.3+, Laravel 10–12
- Filament v4 and v5 (tested in CI, no direct dependency)
- CI matrix runs: PHP 8.3/8.4 × Laravel 10/11/12 × prefer-lowest/prefer-stable × ubuntu/windows, plus separate Filament v4/v5 jobs

## Key Conventions

- Never use debugging functions (`dd`, `dump`, `ray`) — architecture test enforces this
- Always run `composer format` before committing
- Always update `CHANGELOG.md` for all changes — newest entries go at the top, `## Unreleased` section sits above the latest tagged version
- Always use semver for tagging and releases (e.g., v1.3.0, v1.3.1) — never use short tags like v1.3
- Tests use Pest with Orchestra Testbench; use `#[Test]` attributes
- Prefer direct `Filesystem` injection over `app()` or facades for simple action classes
