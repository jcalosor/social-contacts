<?php
declare(strict_types=1);

namespace App\Events;

final class UserContactsEvent extends AbstractEvent
{
    private array $parameters;

    private string $userConnectionsId;

    public function __construct(string $userConnectionsId, array $parameters)
    {
        $this->userConnectionsId = $userConnectionsId;
        $this->parameters = $parameters;
    }

    /**
     * Return the parameters required by the event
     *
     * @return mixed[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getUserConnectionId(): string
    {
        return $this->userConnectionsId;
    }
}
