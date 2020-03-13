<?php
declare(strict_types=1);

namespace App\Services\ApiServices;

use App\Database\Models\User;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use Illuminate\Http\Request as HttpRequest;

final class ApiRequest implements ApiRequestInterface
{
    /**
     * Incoming http request
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create new request instance
     *
     * @param \Illuminate\Http\Request $request Incoming http request
     */
    public function __construct(HttpRequest $request)
    {
        // Create symfony request and merge in passed request
        $httpRequest = $request::capture();
        $this->request = $request->duplicate(
            \array_merge($httpRequest->query->all(), $request->query->all()),
            \array_merge($httpRequest->request->all(), $request->request->all()),
            \array_merge($httpRequest->attributes->all(), $request->attributes->all()),
            \array_merge($httpRequest->cookies->all(), $request->cookies->all()),
            \array_merge($httpRequest->files->all(), $request->files->all()),
            \array_merge($httpRequest->server->all(), $request->server->all())
        );

        // Set headers due to this being a special
        $this->request->headers->replace(\array_merge($httpRequest->headers->all(), $request->headers->all()));
    }

    /**
     * Get client ip address
     *
     * @return string|null
     */
    public function getClientIp(): ?string
    {
        return $this->request->getClientIp();
    }

    /**
     * Get a header by name
     *
     * @param string $key The key to find
     * @param mixed $default The default to return if key isn't found
     *
     * @return mixed
     */
    public function getHeader(string $key, $default = null)
    {
        return $this->request->headers->get($key, $default);
    }

    /**
     * Retrieve the server host
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->request->getHost();
    }

    /**
     * Return the instance of request.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest(): HttpRequest
    {
        return $this->request;
    }

    /**
     * Get user from request
     *
     * @return null|\App\Database\Models\User
     */
    public function getUser(): ?User
    {
        return $this->request->user();
    }

    /**
     * Determine if the request contains a given input item key
     *
     * @param string $key The key to find
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->request->has($key);
    }

    /**
     * Retrieve an input item from the request
     *
     * @param string|null $key The key to retrieve from the input
     * @param mixed $default The default value to use if key isn't set
     *
     * @return mixed
     */
    public function input(?string $key = null, $default = null)
    {
        return $this->request->input($key, $default);
    }

    /**
     * Merge a new data set into an existing request
     *
     * @param mixed[] $data The data to merge into the request
     *
     * @return static
     */
    public function merge(array $data): self
    {
        $this->request->merge($data);

        return $this;
    }

    /**
     * Implement filtered inputs.
     *
     * @param string[] $keys
     *
     * @return mixed[]
     */
    public function only(array $keys): array
    {
        return $this->request->only($keys);
    }

    /**
     * Replace request with a new set of data
     *
     * @param mixed[] $data The data to replace in the request
     *
     * @return static
     */
    public function replace(array $data): self
    {
        $this->request->replace($data);

        return $this;
    }

    /**
     * Set a header on the request
     *
     * @param string $key The key to set
     * @param mixed $value The value to set against the header
     *
     * @return static
     */
    public function setHeader(string $key, $value): self
    {
        $this->request->headers->set($key, $value);

        return $this;
    }

    /**
     * Retrieve the entire request as an array
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->request->all();
    }
}
