<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\MessageThreads;
use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\MessageThreadRepositoryInterface;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;

final class MessageController extends AbstractController
{
    /**
     * Instance of the message thread repository.
     *
     * @var \App\Database\Repositories\Interfaces\MessageThreadRepositoryInterface
     */
    private MessageThreadRepositoryInterface $messageThreadRepository;

    /**
     * Instance of the user connection repository.
     *
     * @var \App\Database\Repositories\Interfaces\UserContactRepositoryInterface
     */
    private UserContactRepositoryInterface $userContactRepository;

    /**
     * MessageController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Database\Repositories\Interfaces\MessageThreadRepositoryInterface $messageThreadRepository
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Database\Repositories\Interfaces\UserContactRepositoryInterface $userContactRepository
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        MessageThreadRepositoryInterface $messageThreadRepository,
        TranslatorInterface $translator,
        UserContactRepositoryInterface $userContactRepository,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->messageThreadRepository = $messageThreadRepository;
        $this->userContactRepository = $userContactRepository;
    }

    /**
     * Create the message thread and messages between sender and receiver.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     * @param string $contactsId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function create(ApiRequestInterface $request, string $userId, string $contactsId): ApiResponseInterface
    {
        if (null !== $message = $request->input('message', null)) {
            $request->merge(['message_word_count' => (int)\str_word_count($message)]);
        }
        if (null !== $title = $request->input('title', null)) {
            $request->merge(['title_word_count' => (int)\str_word_count($title)]);
        }
        $request->merge(['sender_id' => $userId]);

        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        /** @var null|\App\Database\Models\UserContact $userContact */
        $userContact = $this->userContactRepository->find($contactsId);

        if ($userContact === null) {
            return $this->apiResponseFactory->createNotFound(UserContact::class, $contactsId);
        }

        $messageThreads = new MessageThreads([
            'title' => $title,
            'user_connections_id' => $userContact->getUserConnections()->getKey()
        ]);

        $this->messageThreadRepository->save($messageThreads);

        $request->toArray(['message_word_count']);

        return $this->apiResponseFactory->createSuccess($messageThreads->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'message_thread_id' => 'string|required|exists:message_threads,id',
            'message' => 'string|required',
            'message_word_count' => 'int|max:5',
            'receiver_id' => 'string|required|exists:users,id',
            'sender_id' => 'string|required|exists:users,id',
            'status' => 'string|required',
            'title' => 'string|required',
            'title_word_count' => 'int|max:1'
        ];
    }
}
