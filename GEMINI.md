# Project: Laravel make:action Command

## Overview

This project is a Laravel package that provides a `php artisan make:action` command. This command will allow developers to quickly scaffold "Action" classes, which are simple, focused classes that perform a single task. This encourages a more organized and reusable codebase by encapsulating business logic into dedicated classes.

## Base Skeleton

The package will be built upon the `spatie/package-skeleton-laravel` skeleton, ensuring it follows modern package development best practices for the Laravel ecosystem.

## Core Features

-   **Artisan Command:** Introduces a new command: `php artisan make:action {name}`.
-   **Class Generation:** Generates a new action class file in the `app/Actions/` directory.
-   **Directory Creation:** Automatically creates the `app/Actions` directory if it does not already exist.
-   **Stub-based Generation:** Uses a stub file to define the template for the generated action class.
-   **Namespace Handling:** Correctly sets the namespace for the generated class (e.g., `Webteractive\MakeAction\Actions`).
-   **Customizable Method Name:** Allow configuration of the default method name (e.g., `execute` instead of `handle`) via the package's config file.
-   Use **Laravel Prompts** for asking the class name if the class name is not supplied.

## Technical Specifications

### Command Signature

```bash
php artisan make:action CreateNewUser
```

### Generated File

-   **Path:** `app/Actions/CreateNewUser.php`
-   **Content (from stub):**

    ```php
    <?php

    namespace App\Actions;

    class CreateNewUser
    {
        public function handle()
        {
            // TODO: Implement the action logic.
        }
    }
    ```

### Stub File

A `stubs/action.stub` file will be created within the package to serve as the template.

```php
<?php

namespace {{ namespace }};

class {{ class }}
{
    public function handle()
    {
        // TODO: Implement the action logic.
    }
}
```

## Development Plan

Refer to `TODO.md` for the development plan and progress.

1.  **Setup:** Initialize a new Laravel package using the `spatie/package-skeleton-laravel` template.
2.  **Command Class:** Create the `MakeActionCommand.php` file in the `src/Commands` directory.
3.  **Stub Creation:** Create the `action.stub` file in a `stubs` directory.
4.  **Command Logic:** Implement the logic within the command to:
    -   Accept the `name` argument.
    -   Determine the file path and namespace.
    -   Read the stub file.
    -   Replace placeholders (`{{ namespace }}`, `{{ class }}`).
    -   Ensure the `app/Actions` directory exists.
    -   Write the new class file to the destination.
5.  **Verify (Standards):** VERY IMPORTANT: After making code changes, execute the project-specific build, linting and type-checking commands (e.g., 'tsc', 'npm run lint', 'ruff check .', 'vendor/bin/pint') that you have identified for this project (or obtained from the user). This ensures code quality and adherence to standards. If unsure about these commands, you can ask the user if they'd like you to run them and if so how to.
