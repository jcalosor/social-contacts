<?php
declare(strict_types=1);

namespace App\Exceptions\Interfaces;

interface ValidationExceptionInterface extends ExceptionInterface
{
    /**
     * Get validation errors
     *
     * @return mixed[]
     */
    public function getErrors(): array;
}
