<?php

namespace App\Providers;

use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
       /* if ($this->app->environment() !== 'production') {

        }*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        \Schema::defaultStringLength(191);

        $passport = config('passport');

        Passport::tokensExpireIn($passport['expiry']['access_token']);
        Passport::refreshTokensExpireIn($passport['expiry']['refresh_token']);
        LumenPassport::tokensExpireIn($passport['expiry']['access_token']);

        Passport::tokensCan([
            'user' => 'Allow access to user routes'
        ]);
    }
}
