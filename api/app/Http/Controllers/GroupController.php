<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\Group;
use App\Database\Repositories\Interfaces\GroupRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;

final class GroupController extends AbstractController
{
    /**
     * Instance of Group Repository Class.
     *
     * @var \App\Database\Repositories\Interfaces\GroupRepositoryInterface
     */
    private GroupRepositoryInterface $groupRepository;

    /**
     * GroupController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Database\Repositories\Interfaces\GroupRepositoryInterface $userRepository
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        GroupRepositoryInterface $userRepository,
        TranslatorInterface $translator,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->groupRepository = $userRepository;
    }

    /**
     * Create a group from the supplied request.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function create(ApiRequestInterface $request): ApiResponseInterface
    {
        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        $group = new Group($request->toArray());

        $this->groupRepository->save($group);

        return $this->apiResponseFactory->createSuccess($group->toArray(), 201);
    }

    /**
     * Return the found group from the specified groupId.
     *
     * @param string $groupId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function get(string $groupId): ApiResponseInterface
    {
        $group = $this->groupRepository->find($groupId);

        if ($group === null) {
            return $this->apiResponseFactory->createNotFound($groupId, Group::class);
        }

        return $this->apiResponseFactory->createSuccess($group->toArray());
    }

    /**
     * Return a list of all the available groups.
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function list(): ApiResponseInterface
    {
        return $this->apiResponseFactory->createSuccess($this->groupRepository->all());
    }

    /**
     * Update group based from the provided groupId.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $groupId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function update(ApiRequestInterface $request, string $groupId): ApiResponseInterface
    {
        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }
        $group = $this->groupRepository->find($groupId);
        $group->fill($request->toArray());

        $this->groupRepository->save($group);

        return $this->apiResponseFactory->createSuccess($group->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'name' => 'string|required|unique:groups,name',
            'description' => 'string|nullable'
        ];
    }
}
