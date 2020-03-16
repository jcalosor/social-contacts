<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Interfaces\RuntimeExceptionInterface;
use Unostentatious\Repository\Externals\Exceptions\AbstractBaseException;

abstract class AbstractRuntimeException extends AbstractBaseException implements RuntimeExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function getStatusCode(): int
    {
        return self::DEFAULT_STATUS_CODE_RUNTIME;
    }
}
