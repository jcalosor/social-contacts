<?php
declare(strict_types=1);

namespace App\Events;

final class UserContactsEvent extends AbstractEvent
{
    /**
     * Parameters resolved when event was invoked.
     *
     * @var mixed[]
     */
    private array $parameters;

    /**
     * The primary key dependency.
     *
     * @var string
     */
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
