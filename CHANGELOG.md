# Changelog

All notable changes to `make-action` will be documented in this file.

## Unreleased

### What's Changed

- Added Filament v5 compatibility testing to CI workflow
- Added Filament v4 compatibility testing to CI workflow
- Added Filament-specific Boost guidelines for AI agents working with Filament projects
- Updated README with compatibility matrix including Filament versions

### Filament Support

This release ensures the package works seamlessly with Filament v4 and v5 projects. The package has no conflicts with Filament dependencies and is now tested alongside Filament in CI. New Boost guidelines help AI agents understand how to use action classes effectively in Filament resources, pages, and widgets.

## v1.3.0 - 2026-01-15

### What's Changed

- Added Laravel Boost support with AI guidelines for better AI-assisted development
- Added comprehensive tests for Boost guidelines file
- Updated documentation with Laravel Boost Support section

### Laravel Boost

This release adds support for [Laravel Boost](https://github.com/laravel/boost), providing AI agents with context on how to properly use the `make:action` command. When users install Laravel Boost in their applications, these guidelines are automatically discovered and included in their AI context.

**Full Changelog**: https://github.com/webteractive/make-action/compare/v1.2...v1.3.0

## 1.3.0 - 2026-01-15

- Added Laravel Boost support with AI guidelines for better AI-assisted development.
- Added tests for Boost guidelines file.

## 1.0.0 - 2025-07-21

- Added `make:action` command.
- Updated package namespace from `GlenBangkila\MakeAction` to `Webteractive\MakeAction`.
- Added Laravel Prompts support for interactive command input.
- Added `laravel/prompts` as a dev dependency.
