# Issue Demonstration

This project is [a MVP of an issue #1793 of spatie/laravel-permission](https://github.com/spatie/laravel-permission/issues/1793)

## Installation

As this is default Laravel app, general installation instructions for Laravel apply

* `composer install`
* `php artisan key:generate`
* `php artisan migrate --seed`
* Either `php artisan serve` or `vendor/bin/phpunit`

## Database

Despite mentioning MySQL in the issue appears on SQLite aswell, so for portability sake `.env.example` contains setting that switches DB connector to `sqlite` from `mysql`

Inside seeder is included to create 

* one user `Test` (`admin@example.com`) with password `admin`, 
* two roles for both `api` and `web` guards
* one permission per role to go with it with matching `guard`
* Permissions linked to the roles and both roles given out to the user `Test`

Seeder is *not* safely rerunnable 

## Testing

There is a minimal test suite [included](tests/Feature/IssueTest.php), which illustrates expected behaviour