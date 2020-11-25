### Laravel Tranzzo

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
TRANZZO_API_URL=https://cpay.tranzzo.com/api/v1
TRANZZO_ENDPOINTS_KEY=
TRANZZO_WIDGET_KEY=

# client to merchant (payment)
TRANZZO_POS_ID=
TRANZZO_API_KEY=
TRANZZO_API_SECRET=

# merchant to client (credit)
TRANZZO_CREDIT_POS_ID=
TRANZZO_CREDIT_API_KEY=
TRANZZO_CREDIT_API_SECRET=

```

## Usage



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email v.taranenko@artjoker.net instead of using the issue tracker.

## Credits

- [Volodymyr Taranenko](https://github.com/VT2)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


