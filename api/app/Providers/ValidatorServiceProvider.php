<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Services\Validator\Validator;
use Carbon\Laravel\ServiceProvider;

final class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register all the services involved with the Validator Service.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ValidatorInterface::class, Validator::class);
    }
}
