<?php
declare(strict_types=1);

namespace App\Utils\ApiConstructs;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

abstract class AbstractApiResponse extends Response implements ApiResponseInterface
{
    /**
     * AbstractApiResponse constructor.
     *
     * @param mixed $content
     * @param int|null $statusCode
     * @param mixed[]|null $headers
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($content, ?int $statusCode = null, ?array $headers = null)
    {
        parent::__construct();

        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = new ResponseHeaderBag($headers ?? []);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers->all();
    }
}
