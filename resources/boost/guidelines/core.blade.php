## make:action Command

This package provides a `make:action` Artisan command to scaffold Action classes for organizing business logic in Laravel applications.

### Features

- **Action Class Generation**: Creates action classes in `app/Actions` directory with a customizable method name.
- **Configurable Method Name**: The default method name (`handle`) can be customized via config file.

### Creating Actions

Generate a new action class using the Artisan command:

@verbatim
<code-snippet name="Generate an action class" lang="bash">
php artisan make:action CreateNewUser
</code-snippet>
@endverbatim

This creates a class at `app/Actions/CreateNewUser.php` with a `handle()` method.

### Configuration

Publish the configuration file to customize the default method name:

@verbatim
<code-snippet name="Publish configuration" lang="bash">
php artisan vendor:publish --tag="make-action-config"
</code-snippet>
@endverbatim

Change the method name in `config/make-action.php`:

@verbatim
<code-snippet name="Customize method name" lang="php">
return [
    'method_name' => 'execute', // Change from 'handle' to 'execute'
];
</code-snippet>
@endverbatim

### Usage Examples

@verbatim
<code-snippet name="Basic action class structure" lang="php">
<?php

namespace App\Actions;

class CreateNewUser
{
    public function handle(array $data)
    {
        // Implement your business logic here
        // Example: User creation, validation, notifications, etc.
    }
}
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Using an action in a controller" lang="php">
use App\Actions\CreateNewUser;

class UserController extends Controller
{
    public function store(Request $request, CreateNewUser $action)
    {
        $user = $action->handle($request->validated());

        return redirect()->route('users.show', $user);
    }
}
</code-snippet>
@endverbatim

### Best Practices

- Keep actions focused on a single responsibility (Single Responsibility Principle).
- Use dependency injection in action constructors for services and repositories.
- Actions are ideal for encapsulating complex business logic that doesn't belong in controllers or models.
- Consider using actions for operations like: user registration, payment processing, report generation, data imports, etc.
