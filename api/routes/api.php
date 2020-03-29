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
        // :AuthController
        $router->group(['prefix' => 'auth'], function () use ($router): void {
            $router->post('/sign-in', 'AuthController@signIn');
            $router->post('/sign-up', 'AuthController@signUp');

            $router->group(['middleware' => ['auth', 'user.verify_user_credentials']], function () use ($router): void {
                $router->post('/sign-out/{userId}', 'AuthController@signOut');
            });
        });

        // Routes that need's to be authenticated
        $router->group(['middleware' => 'auth'], function () use ($router): void {
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

                // :UserConnectionController
                $router->group(['prefix' => '{userId}/connection'], function () use ($router): void {
                    $router->post('/', 'UserConnectionController@create');
                    $router->delete('/{connectionId}', 'UserConnectionController@delete');
                    $router->put('/{connectionId}/{status}', 'UserConnectionController@update');
                });

                // :UserContactController
                $router->group(['prefix' => '{userId}/contact'], function () use ($router): void {
                    $router->get('/', 'UserContactController@list');
                    $router->get('/{userConnectionId}', 'UserContactController@getByConnectionId');

                    // :MessageController - create a message
                    $router->group(['middleware' => 'user.verify_sender_credentials'], function () use ($router): void {
                        $router->post('/{userConnectionId}/message', 'MessageController@create');
                        $router->post(
                            '/{userConnectionId}/message/{messageThreadId}',
                            'MessageController@createMessage'
                        );
                    });

                    $router->delete('/{userConnectionId}/message/{messageThreadId}', 'MessageController@delete');
                });

                // :MessageController
                $router->group(['prefix' => '{userId}/message'], function () use ($router): void {
                    $router->get('/', 'MessageController@list');
                });
            });
        });
    });
});

