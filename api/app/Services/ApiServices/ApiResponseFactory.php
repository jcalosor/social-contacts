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
     * @inheritDoc
     */
    public function createEmpty(?array $headers = null): ApiResponseInterface
    {
        return new NoContentApiResponse(null, $headers);
    }

    /**
     * @inheritDoc
     */
    public function createError($content, ?array $headers = null): ApiResponseInterface
    {
        $code = 500;

        return $this->__create($this->composeContent(null, null, $code, null), $code, $headers);
    }

    /**
     * @inheritDoc
     */
    public function createForbidden(?array $headers = null): ApiResponseInterface
    {
        $code = 403;

        return $this->__create($this->composeContent('responses.forbidden', null, $code, null), $code, $headers);
    }

    /**
     * @inheritDoc
     */
    public function createNotFound(string $model, ?string $id = null, ?array $headers = null): ApiResponseInterface
    {
        $code = 200;

        return $this->__create(
            $this->composeContent('responses.not_found', null, $code, null, ['id' => $id, 'model' => $model]),
            $code,
            $headers
        );
    }

    /**
     * @inheritDoc
     */
    public function createSuccess(
        $content,
        ?int $code = null,
        ?array $headers = null,
        ?string $message = null
    ): ApiResponseInterface {
        $code = $code ?? 200;

        return $this->__create(
            $this->composeContent($message ?? 'responses.success', $content, $code, null),
            $code,
            $headers
        );
    }

    /**
     * @inheritDoc
     */
    public function createUnauthorized($content = null, ?array $headers = null): ApiResponseInterface
    {
        $code = 401;

        return $this->__create(
            $this->composeContent('responses.unauthorized', $content, $code, null),
            $code,
            $headers
        );
    }

    /**
     * @inheritDoc
     */
    public function createValidationError(?array $errors = null, ?array $headers = null): ApiResponseInterface
    {
        $code = 400;

        return $this->__create(
            $this->composeContent('responses.validation_error', null, $code, $errors),
            $code,
            $headers
        );
    }

    /**
     * Returns a formatted response array.
     *
     * @param null|string $message
     * @param null|array $data
     * @param null|int $code
     * @param null|array $errors
     * @param null|array $replace
     *
     * @return mixed[]
     */
    protected function composeContent(
        ?string $message = null,
        ?array $data = null,
        ?int $code = null,
        ?array $errors = null,
        ?array $replace = null
    ): array {
        $code = $code ?? 200;

        if ($errors !== null) {
            $errorMessage = $message ?? 'responses.error';

            return [
                'message' => $this->translator->trans($errorMessage),
                'errors' => $errors,
                'code' => $code
            ];
        }

        return [
            'message' => $replace ? $this->translator->trans($message, $replace) : $this->translator->trans($message),
            'data' => $data,
            'code' => $code
        ];
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
    private function __create($content, ?int $statusCode = null, ?array $headers = null): ApiResponseInterface
    {
        return new ApiResponse($content, $statusCode, $headers);
    }
}
