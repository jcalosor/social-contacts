<?php
declare(strict_types=1);

namespace App\Services\ApiServices;

use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Utils\ApiConstructs\ApiResponse;
use App\Utils\ApiConstructs\ApiResponseInterface;
use App\Utils\ApiConstructs\NoContentApiResponse;

final class ApiResponseFactory implements ApiResponseFactoryInterface
{
    /**
     * @var \App\Services\ApiServices\Interfaces\TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * ApiResponseFactory constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Create a formatted api response for given parameters.
     *
     * @param mixed $content
     * @param null|int $statusCode
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function create($content, ?int $statusCode = null, ?array $headers = null): ApiResponseInterface
    {
        return new ApiResponse($content, $statusCode, $headers);
    }

    /**
     * Create an empty formatted api response.
     *
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createEmpty(?array $headers = null): ApiResponseInterface
    {
        return new NoContentApiResponse(null, $headers);
    }

    /**
     * Create an error formatted api response.
     *
     * @param mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createError($content, ?array $headers = null): ApiResponseInterface
    {
        return $this->create($content, 500, $headers);
    }

    /**
     * Return a forbidden formatted api response.
     *
     * @param null|mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createForbidden($content = null, ?array $headers = null): ApiResponseInterface
    {
        $content = $content ?? ['message' => $this->translator->trans('responses.forbidden')];

        return $this->create($content, 403, $headers);
    }

    /**
     * Return a success formatted api response.
     *
     * @param mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createSuccess($content, ?array $headers = null): ApiResponseInterface
    {
        return $this->create($content, 201, $headers);
    }

    /**
     * Return an unauthorized formatted api response.
     *
     * @param null|mixed $content
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createUnauthorized($content = null, ?array $headers = null): ApiResponseInterface
    {
        $content = $content ?? ['message' => $this->translator->trans('responses.unauthorized')];

        return $this->create($content, 401, $headers);
    }
}
