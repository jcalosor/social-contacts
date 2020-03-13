<?php
declare(strict_types=1);

namespace App\Utils\ApiConstructs;

class ApiResponse extends AbstractApiResponse
{
    /**
     * ApiResponse constructor.
     *
     * @param mixed $content
     * @param int|null $statusCode
     * @param mixed[]|null $headers
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($content, ?int $statusCode = null, ?array $headers = null)
    {
        parent::__construct($content, $statusCode ?? 200, $headers);
    }
}
