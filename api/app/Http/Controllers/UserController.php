<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\User;
use App\Database\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;
use Illuminate\Support\Facades\Hash;

final class UserController extends AbstractController
{
    /**
     * Instance of User Repository Class.
     *
     * @var \App\Database\Repositories\Interfaces\UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * GroupController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Database\Repositories\Interfaces\UserRepositoryInterface $userRepository
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        TranslatorInterface $translator,
        UserRepositoryInterface $userRepository,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->userRepository = $userRepository;
    }

    /**
     * Create a user and return the created data.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function create(ApiRequestInterface $request): ApiResponseInterface
    {
        $request->merge(['avatar' => User::AVATAR]);

        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }
        $password = ['password' => Hash::make($request->input('password'))];

        $request->merge($password);

        $user = new User($request->toArray());

        $this->userRepository->save($user);

        return $this->apiResponseFactory->createSuccess($user->toArray(), 201);
    }

    /**
     * Return the found user from the specified userId.
     *
     * @param string $userId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function get(string $userId): ApiResponseInterface
    {
        $user = $this->userRepository->find($userId);

        if ($user === null) {
            return $this->apiResponseFactory->createNotFound(User::class, $userId);
        }

        return $this->apiResponseFactory->createSuccess($user->toArray());
    }

    /**
     * Return a list of all the available users.
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function list(): ApiResponseInterface
    {
        return $this->apiResponseFactory->createSuccess($this->userRepository->all());
    }

    /**
     * Update user based from the provided userId.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function update(ApiRequestInterface $request, string $userId): ApiResponseInterface
    {
        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }
        $user = $this->userRepository->find($userId);
        $user->fill($request->toArray());

        $this->userRepository->save($user);

        return $this->apiResponseFactory->createSuccess($user->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'avatar' => 'string|required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'password' => 'string|required|min:6',
            'address' => 'string|required',
            'city' => 'string|required',
            'zip' => 'numeric|required|digits_between:4,6',
            'country' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'phone' => 'string|required'
        ];
    }
}
