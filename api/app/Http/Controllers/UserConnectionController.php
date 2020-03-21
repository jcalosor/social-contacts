<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\AbstractModel;
use App\Database\Models\UserConnections;
use App\Database\Repositories\Interfaces\UserConnectionRepositoryInterface;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use App\Database\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;

final class UserConnectionController extends AbstractController
{

    private UserConnectionRepositoryInterface $userConnectionRepository;

    private UserContactRepositoryInterface $userContactRepository;

    private UserRepositoryInterface $userRepository;

    /**
     * UserConnectionController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Database\Repositories\Interfaces\UserConnectionRepositoryInterface $userConnectionRepository
     * @param \App\Database\Repositories\Interfaces\UserContactRepositoryInterface $userContactRepository
     * @param \App\Database\Repositories\Interfaces\UserRepositoryInterface $userRepository
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        TranslatorInterface $translator,
        UserConnectionRepositoryInterface $userConnectionRepository,
        UserContactRepositoryInterface $userContactRepository,
        UserRepositoryInterface $userRepository,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->userConnectionRepository = $userConnectionRepository;
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
        $request->merge(['inviter_id' => $userId, 'status' => AbstractModel::PENDING_STATUS]);

        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        // We'll have to validate that the requested connection is not yet existing.
        /** @var null|\App\Database\Models\UserConnections $userConnection */
        $userConnection = $this->userConnectionRepository->findOneBy($request->only([
            'inviter_id',
            'invitee_id'
        ]));

        if ($userConnection !== null) {
            if ($userConnection->status === $request->input('status') || $userConnection->status === AbstractModel::ACCEPTED_STATUS) {
                return $this->apiResponseFactory->createValidationError(['user_connection' => 'Connection request already exists.']);
            }

            // If the `status` is different from pending or accepted, this means the user is trying to reconnect.
            if ($userConnection->status === AbstractModel::DECLINED_STATUS) {
                // We'll have to update that user connection to pending status again.
                $userConnection->fill(['status' => AbstractModel::PENDING_STATUS]);
                $this->userConnectionRepository->save($userConnection);

                return $this->apiResponseFactory->createSuccess(
                    $userConnection->toArray(),
                    200,
                    null,
                    'responses.success_connection_request'
                );
            }
        }

        /** @var \App\Database\Models\User $invitee */
        $invitee = $this->userRepository->find($request->input('invitee_id'));

        /** @var \App\Database\Models\User $inviter */
        $inviter = $this->userRepository->find($request->input('inviter_id'));

        $userConnection = (new UserConnections($request->only(['status'])))
            ->setInvitee($invitee)
            ->setInviter($inviter);

        $this->userConnectionRepository->save($userConnection);

        // @todo: Call an event here that will publish the creation of the user connection.
        // with this, the corresponding user contact will be created
        return $this->apiResponseFactory->createSuccess($userConnection->toArray(), 201);
    }

    /**
     * Delete's a user's connection.
     *
     * @param string $userId
     * @param string $connectionId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     * @throws \Exception
     */
    public function delete(string $userId, string $connectionId): ApiResponseInterface
    {
        /** @var null|\App\Database\Models\UserConnections $userConnection */
        $userConnection = $this->userConnectionRepository->find($connectionId);

        if ($userConnection === null) {
            return $this->apiResponseFactory->createNotFound(UserConnections::class, $connectionId);
        }

        if ($userConnection->status === UserConnections::PENDING_STATUS && $userConnection->getInvitee()->getKey() === $userId) {
            return $this->apiResponseFactory->createForbidden();
        }

        $this->userConnectionRepository->delete($userConnection);

        return $this->apiResponseFactory->createEmpty();
    }

    /**
     * Update the user connections status.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     * @param string $connectionId
     * @param string $status
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function update(
        ApiRequestInterface $request,
        string $userId,
        string $connectionId,
        string $status
    ): ApiResponseInterface {
        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        /** @var null|\App\Database\Models\UserConnections $userConnections */
        $userConnections = $this->userConnectionRepository->find($connectionId);

        if ($userConnections === null) {
            return $this->apiResponseFactory->createNotFound(UserConnections::class, $connectionId);
        }

        if (
            \array_key_exists($status, UserConnections::$statusMapper) === false ||
            null === $connectionStatus = $this->__resolveConnectionStatus($userConnections, $userId, $status)
        ) {
            return $this->apiResponseFactory->createValidationError(['invalid_status' => 'Invalid status provided.']);
        }

        $userConnections->fill(['status' => $connectionStatus]);

        $this->userConnectionRepository->save($userConnections);

        return $this->apiResponseFactory->createSuccess($userConnections->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'invitee_id' => 'string|required|exists:users,id',
            'inviter_id' => 'string|required|exists:users,id'
        ];
    }

    /**
     * Resolve the status mappings per user role.
     *
     * @param \App\Database\Models\UserConnections $userConnections
     * @param string $userId
     * @param string $status
     *
     * @return null|string
     */
    private function __resolveConnectionStatus(
        UserConnections $userConnections,
        string $userId,
        string $status
    ): ?string {
        if ($userConnections->getInvitee()->getKey() === $userId) {
            return UserConnections::$inviteeStatuses[$status] ?? null;
        }

        if ($userConnections->getInviter()->getKey() === $userId) {
            return UserConnections::$inviterStatuses[$status] ?? null;
        }

        return null;
    }
}
