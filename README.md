# Laravel make:action Command

[![Latest Version on Packagist](https://img.shields.io/packagist/v/webteractive/make-action.svg?style=flat-square)](https://packagist.org/packages/webteractive/make-action)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/webteractive/make-action/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/webteractive/make-action/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/webteractive/make-action/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/webteractive/make-action/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/webteractive/make-action.svg?style=flat-square)](https://packagist.org/packages/webteractive/make-action)

This Laravel package provides a `php artisan make:action` command to quickly scaffold "Action" classes. This encourages organized and reusable business logic.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/make-action.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/make-action)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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
