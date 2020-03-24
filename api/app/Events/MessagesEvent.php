<?php
declare(strict_types=1);

namespace App\Events;

final class MessagesEvent extends AbstractEvent
{
    /**
     * The primary key dependency.
     *
     * @var string
     */
    private string $messageThreadsId;

    /**
     * Parameters resolved when event was invoked.
     *
     * @var mixed[]
     */
    private array $parameters;

    /**
     * MessagesEvent constructor.
     *
     * @param string $messageThreadsId
     * @param array $parameters
     */
    public function __construct(string $messageThreadsId, array $parameters)
    {
        $this->messageThreadsId = $messageThreadsId;
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
        return $this->messageThreadsId;
    }
}
