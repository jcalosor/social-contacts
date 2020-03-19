<?php
declare(strict_types=1);

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

/**
 * @var \Laravel\Lumen\Routing\Router $router
 */
$router->group(['prefix' => 'api'], function () use ($router): void {
    $router->group(['prefix' => 'v1'], function () use ($router): void {
        // :GroupController
        $router->group(['prefix' => 'group'], function () use ($router): void {
            $router->get('/', 'GroupController@list');
            $router->post('/', 'GroupController@create');
            $router->get('/{groupId}', 'GroupController@get');
            $router->put('/{groupId}', 'GroupController@update');
        });

        // :UserController
        $router->group(['prefix' => 'user'], function () use ($router): void {
            $router->get('/', 'UserController@list');
            $router->post('/', 'UserController@create');
            $router->get('/{userId}', 'UserController@get');
            $router->put('/{userId}', 'UserController@update');

            // :UserContactController
            $router->group(['prefix' => '{userId}/contact'], function () use ($router): void {
                $router->post('/', 'UserContactController@create');
            });
        });
    });
});

