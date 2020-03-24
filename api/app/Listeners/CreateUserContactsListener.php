<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use App\Events\AbstractEvent;

final class CreateUserContactsListener extends AbstractEventListener
{
    /**
     * Resolved instance of the user contact repository.
     *
     * @var \App\Database\Repositories\Interfaces\UserContactRepositoryInterface
     */
    private UserContactRepositoryInterface $userContactRepository;

    /**
     * CreateContactsListener constructor.
     *
     * @param \App\Database\Repositories\Interfaces\UserContactRepositoryInterface $userContactRepository
     */
    public function __construct(UserContactRepositoryInterface $userContactRepository)
    {
        $this->userContactRepository = $userContactRepository;
    }

    /**
     * @inheritDoc
     */
    public function handle(AbstractEvent $event): void
    {
        // We know that it will always be just two id values from this event,
        // so we can just un-pack it here.
        [$firstId, $secondId] = $event->getParameters();

        $userContacts = [
            new UserContact([
                'user_connections_id' => $event->getPrimaryKey(),
                'contacts_id' => $firstId,
                'users_id' => $secondId
            ]),
            new UserContact([
                'user_connections_id' => $event->getPrimaryKey(),
                'contacts_id' => $secondId,
                'users_id' => $firstId
            ])
        ];

        $this->userContactRepository->save($userContacts);
    }
}
