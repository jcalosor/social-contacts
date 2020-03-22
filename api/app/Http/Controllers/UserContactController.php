<?php
declare(strict_types=1);

namespace App\Http\Controllers;

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
        /** @var null|\App\Database\Models\UserContact $userContact */
        if (null === $userContact = $this->userContactRepository->findOneBy(['user_connections_id' => $userConnectionId])) {
            return $this->apiResponseFactory->createNotFound(UserContact::class, $userConnectionId);
        }

        return $this->apiResponseFactory->createSuccess($userContact->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [];
    }
}
