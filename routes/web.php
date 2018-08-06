<?php

$router->get('/', function () use ($router) {
    return response()->json('Welcome', 200);
});

$router->group(['prefix' => 'api/v1/'], function () use ($router) {

    $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/register', 'AuthController@register');
        $router->post('/login', 'AuthController@login');
        $router->post('/refresh/me', 'AuthController@refreshToken');
    });

    //$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->group([/*'middleware' => 'scopes:user', 'prefix' => 'web',*/
        'namespace' => 'Front'], function () use ($router) {

        $router->get('cities', 'CitiesController@index');
        $router->get('cities/{id}', 'CitiesController@show');
        $router->post('cities', 'CitiesController@store');
        $router->put('cities/{id}', 'CitiesController@update');
        $router->delete('cities/{id}', 'CitiesController@destroy');

        $router->get('categories', 'CategoriesController@index');
        $router->get('categories/{id}', 'CategoriesController@show');
        $router->post('categories', 'CategoriesController@store');
        $router->put('categories/{id}', 'CategoriesController@update');
        $router->delete('categories/{id}', 'CategoriesController@destroy');

        $router->get('jobs', 'JobsController@index');
        $router->get('jobs/{id}', 'JobsController@show');
        $router->post('jobs', 'JobsController@store');
        $router->put('jobs/{id}', 'JobsController@update');
        $router->delete('jobs/{id}', 'JobsController@destroy');
        $router->get('/jobs/{id}/status', 'JobsController@getStatus');

        $router->get('/user', 'UsersController@show');

        $router->post('/upload', 'UploadsController@fileUpload');

        //$router->post('logout','UsersController@logout');
    });
    // });
});