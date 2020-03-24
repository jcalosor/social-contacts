<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Database\Models\Messages;
use App\Database\Repositories\Interfaces\MessageRepositoryInterface;
use App\Events\AbstractEvent;

final class CreateMessagesListener extends AbstractEventListener
{
    /**
     * The instance of message repository.
     *
     * @var \App\Database\Repositories\Interfaces\MessageRepositoryInterface
     */
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @inheritDoc
     */
    public function handle(AbstractEvent $event): void
    {
        $messages = new Messages(
            \array_merge(['message_thread_id' => $event->getPrimaryKey()], $event->getParameters())
        );
        $this->messageRepository->save($messages);
    }
}
