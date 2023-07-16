# Laravel [Tomanpay](https://tomanpay.net/) Client

<a href="https://github.com/jalallinux/laravel-tomanpay">  
    <p align="center"><img src="cover.png" width="100%"></p>    
</a>



[![Latest Stable Version](https://poser.pugx.org/jalallinux/laravel-tomanpay/v)](https://packagist.org/packages/jalallinux/laravel-tomanpay)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/jalallinux/laravel-tomanpay.svg?style=flat-square)](https://packagist.org/packages/jalallinux/laravel-tomanpay)
[![Tests](https://github.com/jalallinux/laravel-tomanpay/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/jalallinux/laravel-tomanpay/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/jalallinux/laravel-tomanpay.svg?style=flat-square)](https://packagist.org/packages/jalallinux/laravel-tomanpay)
<!--delete-->
---
Toman's financial solutions help you to easily and quickly manage your business's financial flows comprehensively, focus on the value you create in your product and not worry about its financial affairs and processes.




## Installation

You can install the package via composer

```bash
composer require jalallinux/laravel-tomanpay
```




## Publish config file

You can publish config file to change default configs

```bash
 php artisan vendor:publish --provider JalalLinuX\\Tomanpay\\TomanpayServiceProvider --tag config
```




## Usage
The main methods are called statically
```php
use \JalalLinuX\Tomanpay\Model\Payment;

// Create new payment
Payment::create(1000, 'https://site.com/callback/path'): Payment

// Fetch an exists payment detail
Payment::detail('7cadba50-6059-424e-9580-c12448a8046e'): Payment

// Get list of payments
Payment::list(): LengthAwarePaginator

// Verify an exist payment
Payment::verify('7cadba50-6059-424e-9580-c12448a8046e', false): bool

// Redirect an exist payment to PSP
Payment::redirect('7cadba50-6059-424e-9580-c12448a8046e'): RedirectResponse
```




## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.




## Credits

- [JalalLinuX](https://github.com/jalallinux)
- [All Contributors](../../contributors)




## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
