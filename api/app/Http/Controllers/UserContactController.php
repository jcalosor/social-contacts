<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\UserConnections;
use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;

final class UserContactController extends AbstractController
{
    /**
     * The resolved instance of the user contact repository.
     *
     * @var \App\Database\Repositories\Interfaces\UserContactRepositoryInterface
     */
    private UserContactRepositoryInterface $userContactRepository;

    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        TranslatorInterface $translator,
        UserContactRepositoryInterface $userContactRepository,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->userContactRepository = $userContactRepository;
    }

    /**
     * Return a user contact by user connection id.
     *
     * @param string $userId
     * @param string $userConnectionId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     * @throws \Exception
     */
    public function getByConnectionId(string $userId, string $userConnectionId): ApiResponseInterface
    {
        /** @var null|\Illuminate\Database\Eloquent\Collection $userContact */
        if (null === $userContact = $this->userContactRepository->findBy([
                'user_connections_id' => $userConnectionId
            ])) {
            return $this->apiResponseFactory->createNotFound(UserConnections::class, $userConnectionId);
        }

        return $this->apiResponseFactory->createSuccess($userContact->toArray());
    }

    /**
     * Return a list of contacts belonging to this user.
     *
     * @param string $userId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function list(string $userId): ApiResponseInterface
    {
        /** @var null|\Illuminate\Database\Eloquent\Collection $contacts */
        $contacts = $this->userContactRepository->getContactsByStatus($userId);

        if ($contacts === null) {
            return $this->apiResponseFactory->createNotFound(UserContact::class, \sprintf('user_id: %s', $userId));
        }

        return $this->apiResponseFactory->createSuccess($contacts->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [];
    }
}
