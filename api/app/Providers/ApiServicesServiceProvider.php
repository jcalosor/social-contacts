<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\ApiServices\ApiRequest;
use App\Services\ApiServices\ApiResponseFactory;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\ApiServices\Translator;
use Illuminate\Contracts\Translation\Translator as ContractedTranslator;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator as IlluminateTranslator;

final class ApiServicesServiceProvider extends ServiceProvider
{
    /**
     * Register all the services involved with the ApiServices Module.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ApiRequestInterface::class, fn(): ApiRequest => $this->__setApiRequest());

        $this->app->bind(
            ContractedTranslator::class,
            fn(): IlluminateTranslator => $this->app->make('translator')
        );
        $this->app->bind(TranslatorInterface::class, Translator::class);
        $this->app->bind(
            ApiResponseFactoryInterface::class,
            fn(): ApiResponseFactory => $this->__setApiResponseFactory()
        );
    }

    /**
     * Create and return a resolved instance of ApiResponseFactory.
     *
     * @return \App\Services\ApiServices\ApiResponseFactory
     */
    private function __setApiResponseFactory(): ApiResponseFactory
    {
        return new ApiResponseFactory($this->app->get(TranslatorInterface::class));
    }

    /**
     * Create and return the instance with the HttpRequest's setTrustedProxies initiated.
     *
     * @return \App\Services\ApiServices\ApiRequest
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function __setApiRequest(): ApiRequest
    {
        HttpRequest::setTrustedProxies(
            \explode(',', \env('TRUSTED_PROXIES') ?? ''),
            HttpRequest::HEADER_X_FORWARDED_ALL
        );

        return $this->app->make(ApiRequest::class);
    }
}
