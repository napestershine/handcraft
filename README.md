### setup project

 - Clone repository
 - make .env file from .env.example
 - set up database
 - run `composer install`
 - run `php artisan migrate:refresh --seed`
 - run `php artisan passport:install`
 - setup api config `php artisan generate:config`
 - to run project `php -S localhost:8000 -t public`





