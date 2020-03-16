<?php
declare(strict_types=1);

namespace App\Http\Controllers;

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
     * @param \App\Database\Repositories\Interfaces\GroupRepositoryInterface $groupRepository
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        GroupRepositoryInterface $groupRepository,
        TranslatorInterface $translator,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->groupRepository = $groupRepository;
    }

    /**
     * Create a group from the supplied request.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     * @throws \App\Exceptions\Validation\RequestValidationException
     */
    public function create(ApiRequestInterface $request): ApiResponseInterface
    {
        $data = $request->toArray();
        $this->validateRequest($data);

        return $this->apiResponseFactory->create($data);
    }

    /**
     * Return a list of all the available groups.
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function get(): ApiResponseInterface
    {
        return $this->apiResponseFactory->createSuccess($this->groupRepository->all());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'name' => 'string|required',
            'description' => 'string|nullable'
        ];
    }
}
