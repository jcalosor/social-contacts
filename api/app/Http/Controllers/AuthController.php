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

final class AuthController extends AbstractUserController
{
    /** @var \App\Database\Repositories\Interfaces\UserRepositoryInterface $userRepository */
    private UserRepositoryInterface $userRepository;

    /**
     * AuthController constructor.
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
     * Sign-in the user, return error for failed attempts, return the resolved user once successful.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     *
     * @noinspection PhpUndefinedFieldInspection
     */
    public function signIn(ApiRequestInterface $request): ApiResponseInterface
    {
        $email = $request->input('email', null);
        $password = $request->input('password', null);
        if (null !== $error =
                $this->validateRequestAndRespond(
                    $request, null,
                    ['email' => 'email|required', 'password' => 'string|required|min:8']
                )
        ) {
            return $error;
        }

        /** @var null|\App\Database\Models\User $user */
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user === null) {
            return $this->apiResponseFactory->createUnauthorized(['email' => $email]);
        }

        if (Hash::check($password, $user->password) === false) {
            return $this->apiResponseFactory->createValidationError(['password' => 'Incorrect']);
        }

        if ((bool)$user->logged_in === true) {
            return $this->apiResponseFactory->createSuccess($user->toArray());
        }

        $user->logged_in = true;

        $this->userRepository->save($user);

        return $this->apiResponseFactory->createSuccess($user->toArray());
    }

    /**
     * Sign out the currently signed-in user, return an error if the user is already signed-out.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function signOut(ApiRequestInterface $request, string $userId): ApiResponseInterface
    {
        if (null !== $error = $this->validateRequestAndRespond($request)) {
            return $error;
        }

        /** @var \App\Database\Models\User $user */
        $user = $this->userRepository->find($userId);

        $user->setRawAttributes(['logged_in' => false]);

        $this->userRepository->save($user);

        return $this->apiResponseFactory->createEmpty();
    }

    /**
     * Create a new user and returned it's resolved instance.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function signUp(ApiRequestInterface $request): ApiResponseInterface
    {
        if (null !== $error = $this->validateRequestAndRespond($request)) {
            return $error;
        }

        if ($this->userRepository->findOneBy(['email' => $request->input('email')]) !== null) {
            return $this->apiResponseFactory->createError(['email' => 'Already exists!']);
        }

        $request->merge(['avatar' => User::AVATAR]);

        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        // Create the password, and log in the newly created user.
        $password = ['password' => Hash::make($request->input('password')), 'logged_in' => true];

        $request->merge($password);

        $user = new User($request->toArray());

        // Usually, after the user has been created, we'll have to dispatch a user event here, to initiate action's
        // like send email or push notifications, but for demo purposes we'll skip that for now ;)
        $this->userRepository->save($user);

        return $this->apiResponseFactory->createSuccess($user->toArray(), 201);
    }
}
