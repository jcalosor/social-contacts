<?php

namespace App\Http\Controllers;

use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    /**
     * Instance of the Api Response Factory class.
     *
     * @var \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface
     */
    protected ApiResponseFactoryInterface $apiResponseFactory;

    /**
     * Instance of the Translator class.
     *
     * @var \App\Services\ApiServices\Interfaces\TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * AbstractController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     */
    public function __construct(ApiResponseFactoryInterface $apiResponseFactory, TranslatorInterface $translator)
    {
        $this->apiResponseFactory = $apiResponseFactory;
        $this->translator = $translator;
    }
}
