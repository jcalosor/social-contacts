<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;
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
     * Validate request and return ApiResponseInterface if validation fails.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return null|\App\Utils\ApiConstructs\ApiResponseInterface
     */
    protected function validateRequestAndRespond(ApiRequestInterface $request): ?ApiResponseInterface
    {
        if (true !== $validate = $this->__validateRequest($request->toArray())) {
            return $this->apiResponseFactory->createValidationError($validate);
        }

        return null;
    }

    /**
     * Validate request against the define validation rules.
     *
     * @param mixed[] $data
     *
     * @return mixed
     */
    private function __validateRequest(array $data)
    {
        if ($this->validator->validate($data, $this->getValidationRules()) === false) {
            return $this->validator->getFailures();
        }

        return true;
    }
}
