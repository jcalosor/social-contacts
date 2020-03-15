<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Repositories\Interfaces\GroupRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
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
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        GroupRepositoryInterface $groupRepository,
        TranslatorInterface $translator
    ) {
        parent::__construct($apiResponseFactory, $translator);

        $this->groupRepository = $groupRepository;
    }

    /**
     * Create a group from the supplied request.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function create(ApiRequestInterface $request): ApiResponseInterface
    {
        return $this->apiResponseFactory->create($request->toArray());
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
}
