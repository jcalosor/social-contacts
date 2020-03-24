<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Models\Messages;
use App\Database\Models\MessageThreads;
use App\Database\Models\UserConnections;
use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\MessageThreadRepositoryInterface;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use App\Events\MessagesEvent;
use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;
use Illuminate\Contracts\Events\Dispatcher;

final class MessageController extends AbstractDispatchController
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
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     * @param \App\Database\Repositories\Interfaces\MessageThreadRepositoryInterface $messageThreadRepository
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Database\Repositories\Interfaces\UserContactRepositoryInterface $userContactRepository
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        Dispatcher $dispatcher,
        MessageThreadRepositoryInterface $messageThreadRepository,
        TranslatorInterface $translator,
        UserContactRepositoryInterface $userContactRepository,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $dispatcher, $translator, $validator);

        $this->messageThreadRepository = $messageThreadRepository;
        $this->userContactRepository = $userContactRepository;
    }

    /**
     * Create the message thread and messages between sender and receiver.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     * @param string $userConnectionId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     *
     * @throws \Exception
     */
    public function create(ApiRequestInterface $request, string $userId, string $userConnectionId): ApiResponseInterface
    {
        if (null !== $message = $request->input('message', null)) {
            $request->merge(['message_word_count' => (int)\str_word_count($message)]);
        }
        if (null !== $title = $request->input('title', null)) {
            $request->merge(['title_word_count' => (int)\str_word_count($title)]);
        }

        $request->merge(['sender_id' => $userId, 'status' => Messages::UNREAD_STATUS]);

        // Title validation rule added on the fly,
        // we don't want to have duplicate title's on the message thread with the same user connection id.
        $titleValidation = [
            'title' => 'string|required|' .
                $this->getUniqueRuleAsString(
                    MessageThreads::TABLE_NAME,
                    'title',
                    null,
                    'id',
                    'user_connections_id',
                    $userConnectionId
                )
        ];
        // Validate first the provided request so we'll avoid making any db calls if something is off.
        if (null !== $errorResponse = $this->validateRequestAndRespond($request, $titleValidation)) {
            return $errorResponse;
        }

        /** @var null|\App\Database\Models\UserContact $userContact */
        $userContact = $this->userContactRepository->findOneBy(['user_connections_id' => $userConnectionId]);

        if ($userContact === null) {
            return $this->apiResponseFactory->createNotFound(UserContact::class, $userConnectionId);
        }
        // If the receiver id does not match the existing contacts id from the user contact
        // and the connection status is not accepted, return a forbidden response.
        /** @noinspection PhpUndefinedFieldInspection due to magic methods from active record */
        if (
            $userContact->getContact()->getKey() !== $request->input('receiver_id') ||
            $userContact->getUserConnections()->status !== UserConnections::ACCEPTED_STATUS
        ) {
            return $this->apiResponseFactory->createUnauthorized($request->only(['receiver_id']));
        }

        $messageThreads = new MessageThreads([
            'title' => $title,
            'user_connections_id' => $userConnectionId
        ]);

        $this->messageThreadRepository->save($messageThreads);

        // Setup the requirements for event dispatch,
        // Remove the unnecessary values so we can proceed with the event dispatch with a clean slate
        $this->eventParameters = $request->toArray(['message_word_count', 'title', 'title_word_count']);
        $this->dispatchEvent($messageThreads->getKey());

        return $this->apiResponseFactory->createSuccess($messageThreads->toArray());
    }

    /**
     * @inheritDoc
     */
    protected function getEventClass(): string
    {
        return MessagesEvent::class;
    }

    /**
     * @inheritDoc
     */
    protected function getEventParameters(): array
    {
        return $this->eventParameters;
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        // This is for update method.
        // 'message_thread_id' => 'string|required|exists:message_threads,id',
        return [
            'message' => 'string|required',
            'message_word_count' => 'int|max:5',
            'receiver_id' => 'string|required|exists:users,id',
            'sender_id' => 'string|required|exists:users,id',
            'title_word_count' => 'int|max:1'
        ];
    }
}
