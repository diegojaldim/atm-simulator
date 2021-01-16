<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {

    $router->group(['prefix' => 'transactions'], function () use ($router) {

        $router->get('withdraw', 'TransactionController@withdraw');

    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@get');
        $router->post('/', 'UserController@post');
    });

    $router->group(['prefix' => 'user/{id}'], function () use ($router) {
        $router->get('/', 'UserController@get');
        $router->put('/', 'UserController@put');
        $router->delete('/', 'UserController@delete');
    });

});