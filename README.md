### setup project

 - Clone repository
 - make .env file from .env.example
 - set up database
 - run `composer install`
 - run `php artisan migrate:refresh --seed`
 - run `php artisan passport:install`
 - setup api config `php artisan generate:config`
 - to run project `php -S localhost:8000 -t public`
 
 ## Run Tests
 - Refresh DB `$ php artisan migrate:fresh; php artisan db:seed`
 - Run `$ vendor/bin/phpunit`

## API doc
- use below in `.env`
```
SWAGGER_GENERATE_ALWAYS=false
SWAGGER_LUME_CONST_HOST=localhost:8000
SWAGGER_VERSION=2.0
```
- run `php artisan swagger-lume:generate`
- run `php artisan swagger-lume:views-publish`
- run `cd public`
- run `php -S localhost:8000 index.php`
- open browser and go to `http://localhost:8000/api/documentation`

## Limitations
- Tests which use DB are slow, it can be improved with sqilte, I tried to use it but it's future work, not enough time for now.
- Auth is disabled, but it can be enabled and used with scopes



