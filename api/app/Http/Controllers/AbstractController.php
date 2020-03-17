<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
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
     * Instance of the validator interface.
     *
     * @var \App\Services\Validator\Interfaces\ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * AbstractController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        TranslatorInterface $translator,
        ValidatorInterface $validator
    ) {
        $this->apiResponseFactory = $apiResponseFactory;
        $this->translator = $translator;
        $this->validator = $validator;
    }

    /**
     * Return the specific validation rules for post, put and patch requests.
     *
     * @return mixed[]
     */
    abstract protected function getValidationRules(): array;

    /**
     * Validate request against the define validation rules.
     *
     * @param mixed[] $request
     *
     * @return mixed
     */
    protected function validateRequest(array $request)
    {
        if ($this->validator->validate($request, $this->getValidationRules()) === false) {
            return $this->validator->getFailures();
        }

        return true;
    }
}
