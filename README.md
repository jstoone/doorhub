<p align="center"><a href="https://doorhub.io" target="_blank"><img src="https://doorhub.io/images/logo/logo_only.png" width="400"></a></p>

## Installing

```
$ git clone https://github.com/jstoone/doorhub
$ cd doorhub
$ composer install
$ cp .env.example .env
$ php artisan key:generate
# [configure database variables]
$ php artisan migrate --seed
```
<p align="center"><a href="https://app.getpostman.com/run-collection/9cc4babdf4ee4f9e5328" target="_blank"><img src="https://run.pstmn.io/button.svg"></a></p>

## Tests
```
$ phpunit
```

## Users
```
Admin:  admin@example.com
Client: john@example.com
Client: jane@example.com

All users have been seeded with password of `password`.
```

## Routes
```
$ php artisan route:list --compact --path=api/

+----------+--------------------------------------+--------------------------------------------------+
| Method   | URI                                  | Action                                           |
+----------+--------------------------------------+--------------------------------------------------+
| GET|HEAD | api/companies                        | App\Http\Controllers\CompanyController@index     |
| POST     | api/companies                        | App\Http\Controllers\CompanyController@store     |
| GET|HEAD | api/companies/{company}              | App\Http\Controllers\CompanyController@show      |
| GET|HEAD | api/companies/{company}/users        | App\Http\Controllers\CompanyUserController@index |
| POST     | api/companies/{company}/users        | App\Http\Controllers\CompanyUserController@store |
| GET|HEAD | api/companies/{company}/users/{user} | App\Http\Controllers\CompanyUserController@show  |
| POST     | api/token                            | App\Http\Controllers\TokenController@store       |
| GET|HEAD | api/users                            | App\Http\Controllers\UserController@index        |
| POST     | api/users                            | App\Http\Controllers\UserController@store        |
| GET|HEAD | api/users/{user}                     | App\Http\Controllers\UserController@show         |
+----------+--------------------------------------+--------------------------------------------------+
```

