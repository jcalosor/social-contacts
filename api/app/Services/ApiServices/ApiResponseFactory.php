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
        $code = 500;

        $content = $content ?? [
                'message' => $this->translator->trans('responses.error'),
                'code' => $code
            ];

        return $this->create($content, $code, $headers);
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
        $code = 403;

        $content = $content ?? [
                'message' => $this->translator->trans('responses.forbidden'),
                'code' => $code
            ];

        return $this->create($content, $code, $headers);
    }

    /**
     * Return a success formatted api response.
     *
     * @param mixed $content
     * @param null|int $code
     * @param null|mixed[] $headers
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function createSuccess($content, ?int $code = null, ?array $headers = null): ApiResponseInterface
    {
        $code = $code ?? 201;

        $content = [
            'message' => $this->translator->trans('responses.success'),
            'data' => $content,
            'code' => $code
        ];

        return $this->create($content, $code, $headers);
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
        $code = 401;

        $content = $content ?? [
                'message' => $this->translator->trans('responses.unauthorized'),
                'code' => $code
            ];

        return $this->create($content, $code, $headers);
    }

    /**
     * @inheritDoc
     */
    public function createValidationError(?array $errors = null, ?array $headers = null): ApiResponseInterface
    {
        $code = 400;

        $content = [
            'message' => $this->translator->trans('responses.validation_error'),
            'errors' => $errors,
            'code' => $code
        ];

        return $this->create($content, $code, $headers);
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
    private function create($content, ?int $statusCode = null, ?array $headers = null): ApiResponseInterface
    {
        return new ApiResponse($content, $statusCode, $headers);
    }
}
