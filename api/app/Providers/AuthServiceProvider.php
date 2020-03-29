<?php

namespace App\Providers;

use App\Database\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /** @var \Illuminate\Auth\AuthManager $authManager */
    private AuthManager $authManager;

    /**
     * AuthServiceProvider constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->authManager = $this->app['auth'];
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->authManager->viaRequest('api', function (Request $request) {
            /** @noinspection PhpUndefinedMethodInspection */
            return User::where(['id' => $request->route('userId'), 'logged_in' => true])->first();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register services
    }
}
