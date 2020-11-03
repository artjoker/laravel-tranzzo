# # Laravel Tranzzo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/artjoker/laravel-tranzzo.svg?style=flat-square)](https://packagist.org/packages/artjoker/laravel-tranzzo)
[![Total Downloads](https://img.shields.io/packagist/dt/artjoker/laravel-tranzzo.svg?style=flat-square)](https://packagist.org/packages/artjoker/laravel-tranzzo)

Integration of Tranzzo payment service for Laravel

## Installation

You can install the package via composer:

```
composer require artjoker/laravel-tranzzo
```
You can publish the config file:
```
php artisan vendor:publish --provider="Artjoker\LaravelTranzzo\TranzzoServiceProvider" --tag="config"
```

Set environment variable (`.env`)
```
RISK_TOOLS_URL=
RISK_TOOLS_KEY=
```

## Usage



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email v.taranenko@artjoker.net instead of using the issue tracker.

## Credits

- [Volodymyr Taranenko](https://github.com/VT2)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


