<?php
declare(strict_types=1);

namespace App\Utils\ApiConstructs;

class NoContentApiResponse extends AbstractApiResponse
{
    /**
     * NoContentApiResponse constructor.
     *
     * @param int|null $statusCode
     * @param mixed[]|null $headers
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(?int $statusCode = null, ?array $headers = null)
    {
        parent::__construct('', $statusCode ?? 204, $headers);
    }
}
