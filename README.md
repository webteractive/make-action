# Laravel make:action Command

This Laravel package provides a `php artisan make:action` command to quickly scaffold "Action" classes. This encourages organized and reusable business logic.

## Installation

You can install the package via composer:

```bash
composer require webteractive/make-action
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="make-action-config"
```

This is the contents of the published config file:

```php
// config for Webteractive/MakeAction
return [
    'method_name' => 'handle',
];
```

## Usage

To create a new action class, run the `make:action` Artisan command:

```bash
php artisan make:action CreateNewUser
```

This will create a new action class at `app/Actions/CreateNewUser.php`:

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

You can customize the default method name (`handle`) by changing the `method_name` value in the `config/make-action.php` file:

```php
// config for Webteractive/MakeAction
return [
    'method_name' => 'execute',
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Glen Bangkila](https://github.com/)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
