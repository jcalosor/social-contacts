<?php
declare(strict_types=1);

namespace App\Utils\ApiConstructs;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AbstractApiResponse extends Response implements ApiResponseInterface
{
    /**
     * The default content type to be returned.
     *
     * @var mixed[]
     */
    private array $jsonContentType = ['Content-Type' => 'application/json'];

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

        $this->content = \json_encode($content);
        $this->statusCode = $statusCode;
        $this->headers = new ResponseHeaderBag(\array_merge($this->jsonContentType, $headers ?? []));
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers->all();
    }
}
