<?php
declare(strict_types=1);

namespace App\Services\ApiServices\Interfaces;

use App\Utils\ApiConstructs\ApiResponseInterface;

interface ApiResponseFactoryInterface
{
    /**
     * Create an empty formatted api response.
     *
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createEmpty(?array $headers = null): ApiResponseInterface;

    /**
     * Create an error formatted api response.
     *
     * @param mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createError($content, ?array $headers = null): ApiResponseInterface;

    /**
     * Create a forbidden formatted api response.
     *
     * @param null|mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createForbidden($content = null, ?array $headers = null): ApiResponseInterface;

    /**
     * Return a success formatted api response.
     *
     * @param mixed $content
     * @param null|int $code
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createSuccess($content, ?int $code = null, ?array $headers = null): ApiResponseInterface;

    /**
     * Create an unauthorized formatted api response.
     *
     * @param null|mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createUnauthorized($content = null, ?array $headers = null): ApiResponseInterface;

    /**
     * Create a validation error formatted api response.
     *
     * @param null|mixed[] $errors
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createValidationError(?array $errors = null, ?array $headers = null): ApiResponseInterface;
}
