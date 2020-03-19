<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\GroupRepositoryInterface;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use App\Database\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;

final class UserContactController extends AbstractController
{
    /** @var \App\Database\Repositories\Interfaces\GroupRepositoryInterface $groupRepository */
    private GroupRepositoryInterface $groupRepository;

    /** @var \App\Database\Repositories\Interfaces\UserContactRepositoryInterface $userContactRepository */
    private UserContactRepositoryInterface $userContactRepository;

    /** @var \App\Database\Repositories\Interfaces\UserRepositoryInterface $userRepository */
    private UserRepositoryInterface $userRepository;

    /**
     * UserContactController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Database\Repositories\Interfaces\GroupRepositoryInterface $groupRepository
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Database\Repositories\Interfaces\UserContactRepositoryInterface $userContactRepository
     * @param \App\Database\Repositories\Interfaces\UserRepositoryInterface $userRepository
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        GroupRepositoryInterface $groupRepository,
        TranslatorInterface $translator,
        UserContactRepositoryInterface $userContactRepository,
        UserRepositoryInterface $userRepository,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->groupRepository = $groupRepository;
        $this->userContactRepository = $userContactRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Create a contact associated to the current user.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function create(ApiRequestInterface $request, string $userId): ApiResponseInterface
    {
        $request->merge(['users_id' => $userId]);

        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        /** @var \App\Database\Models\Group $group */
        $group = $this->groupRepository->find($request->input('groups_id'));

        /** @var \App\Database\Models\User $contact */
        $contact = $this->userRepository->find($request->input('contacts_id'));

        /** @var \App\Database\Models\UserContact $userContact */
        $userContact = (new UserContact(['users_id' => $userId]))
            ->setContact($contact)
            ->setGroup($group);

        $this->userContactRepository->save($userContact);

        return $this->apiResponseFactory->createSuccess($userContact->toArray(), 201);
    }

    /**
     * Delete's a user's contact.
     *
     * @param string $userId
     * @param string $contactId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function delete(string $userId, string $contactId): ApiResponseInterface
    {
        // Body needed here
        return $this->apiResponseFactory->createSuccess([]);
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'contacts_id' => 'string|required|exists:users,id',
            'groups_id' => 'string|required_with:users_id|exists:groups,id',
            'users_id' => 'string|required_with:groups_id|exists:users,id'
        ];
    }
}
