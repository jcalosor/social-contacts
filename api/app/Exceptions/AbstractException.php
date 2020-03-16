<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Interfaces\BaseExceptionInterface;
use Throwable;

abstract class AbstractException extends \Exception implements BaseExceptionInterface
{
    /**
     * @var mixed[]
     */
    protected array $messageParams;

    /**
     * BaseException constructor.
     *
     * @param null|string $message
     * @param mixed[]|null $messageParameters Parameters for $message
     * @param int|null $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        ?string $message = null,
        ?array $messageParameters = null,
        ?int $code = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message ?? '', $code ?? 0, $previous);
        $this->messageParams = $messageParameters ?? [];
    }

    /**
     * @inheritdoc
     */
    public function getMessageParameters(): array
    {
        return $this->messageParams;
    }
}
