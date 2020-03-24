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

    /**
     * UserContactsEvent constructor.
     *
     * @param string $userConnectionsId
     * @param array $parameters
     */
    public function __construct(string $userConnectionsId, array $parameters)
    {
        $this->userConnectionsId = $userConnectionsId;
        $this->parameters = $parameters;
    }

    /**
     * @inheritDoc
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @inheritDoc
     */
    public function getPrimaryKey(): string
    {
        return $this->userConnectionsId;
    }
}
