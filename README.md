# Laravel IDE Helper Hook *"Eloquent Has By Non-Dependent Subquery"*

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery/run-tests?label=tests)](https://github.com/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Coverage Status](https://coveralls.io/repos/github/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery/badge.svg?branch=main)](https://coveralls.io/github/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery?branch=master)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery.svg?style=flat-square)](https://packagist.org/packages/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery)
[![Total Downloads](https://img.shields.io/packagist/dt/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery.svg?style=flat-square)](https://packagist.org/packages/wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery)

A Laravel Package for adding [Eloquent Has By Non-Dependent Subquery](https://github.com/mpyw/eloquent-has-by-non-dependent-subquery) support to Laravel IDE Helper [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper).

## Installation

You can install the package via composer:

```bash
composer require --dev wimski/laravel-ide-helper-hook-eloquent-has-by-non-dependent-subquery
```

The package is loaded using [Package Discovery](https://laravel.com/docs/8.x/packages#package-discovery), when disabled read [Manual Installation](#manual-installation).

## Usage

Run standard model generation commands as normal:

`php artisan ide-helper:models "App\Models\Post"`

Docblocks will be added to the model

```php
/**
 * App\Models\Post
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Post doesntHaveByNonDependentSubquery($relationMethod, ...$constraints) 
 * @method static \Illuminate\Database\Eloquent\Builder|Post hasByNonDependentSubquery($relationMethod, ...$constraints) 
 * @method static \Illuminate\Database\Eloquent\Builder|Post orDoesntHaveByNonDependentSubquery($relationMethod, ...$constraints) 
 * @method static \Illuminate\Database\Eloquent\Builder|Post orHasByNonDependentSubquery($relationMethod, ...$constraints)
 */ 
```

## Manual Installation
When disabled, register the `LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider` manually by adding it to your `config/app.php`

```php
/*
 * Package Service Providers...
 */
 Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Providers\LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider::class,
```

## Testing

```bash
composer test
```

## Credits

- [wimski](https://github.com/wimski)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
