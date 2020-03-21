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
     * Get the unique rule for validation.
     *
     * @param string $tableName
     * @param string $column
     * @param null|int $except
     * @param null|string $idColumn
     *
     * @return string
     */
    protected function getUniqueRuleAsString(
        string $tableName,
        string $column,
        ?int $except = null,
        ?string $idColumn = null
    ): string {
        $idColumn = $idColumn ?? 'id';

        return \sprintf('unique:%s,%s,%s,%s', $tableName, $column, $except, $idColumn);
    }

    /**
     * Validate request and return ApiResponseInterface if validation fails.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param null|mixed[] $additionalRules
     *
     * @return null|\App\Utils\ApiConstructs\ApiResponseInterface
     */
    protected function validateRequestAndRespond(
        ApiRequestInterface $request,
        ?array $additionalRules = null
    ): ?ApiResponseInterface {
        if (true !== $validate = $this->__validateRequest($request->toArray(), $additionalRules)) {
            return $this->apiResponseFactory->createValidationError($validate);
        }

        return null;
    }

    /**
     * Validate request against the define validation rules.
     *
     * @param mixed[] $data
     * @param null|mixed[] $additionalRules
     *
     * @return mixed
     */
    private function __validateRequest(array $data, ?array $additionalRules = null)
    {
        $rules = $this->getValidationRules();
        if ($additionalRules !== null) {
            $rules = \array_merge($this->getValidationRules(), $additionalRules);
        }

        if ($this->validator->validate($data, $rules) === false) {
            return $this->validator->getFailures();
        }

        return true;
    }
}
