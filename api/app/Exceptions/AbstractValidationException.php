<?php
declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

abstract class AbstractValidationException extends AbstractException
{
    /**
     * Validation errors.
     *
     * @var mixed[]
     */
    private array $errors;

    /**
     * Create validation exception
     *
     * @param string|null $message
     * @param mixed[]|null $messageParameters
     * @param int|null $code
     * @param \Throwable|null $previous
     * @param mixed[]|null $errors
     */
    public function __construct(
        ?string $message = null,
        ?array $messageParameters = null,
        ?int $code = null,
        ?Throwable $previous = null,
        ?array $errors = null
    ) {
        parent::__construct($message ?? '', $messageParameters, $code ?? 0, $previous);

        $this->errors = $errors ?? [];
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function getStatusCode(): int
    {
        return self::DEFAULT_STATUS_CODE_VALIDATION;
    }
}
