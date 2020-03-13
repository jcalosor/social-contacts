<?php
declare(strict_types=1);

namespace App\Utils\ApiConstructs;

interface ApiResponseInterface
{
    /**
     * Get response content.
     *
     * @return mixed
     */
    public function getContent();

    /**
     * Get response headers.
     *
     * @return string[]
     */
    public function getHeaders(): array;

    /**
     * Get response status code.
     *
     * @return int
     */
    public function getStatusCode(): int;
}
