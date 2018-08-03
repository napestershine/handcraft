<?php

$router->get('/', function () use ($router) {
    return response()->json('Success', 200);
});

$router->group(['prefix' => 'api/v1/'], function () use ($router) {

    $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/register', 'AuthController@register');
        $router->post('/login', 'AuthController@login');
        $router->post('/refresh/me', 'AuthController@refreshToken');
    });

    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->group(['middleware' => 'scopes:user', 'prefix' => 'web', 'namespace' => 'Front'], function () use ($router) {
            $router->post('/orders', 'OrdersController@store');
            $router->get('/order/{id}/status', 'OrdersController@getStatus');
            $router->get('/user', 'UsersController@show');
            $router->post('logout','UsersController@logout');
        });
    });
});