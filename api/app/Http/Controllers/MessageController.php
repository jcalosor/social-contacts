<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ApiServices\Interfaces\ApiRequestInterface;
use App\Utils\ApiConstructs\ApiResponseInterface;

final class MessageController extends AbstractController
{

    /**
     * Create the message thread and messages between sender and receiver.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiRequestInterface $request
     * @param string $userId
     *
     * @return \App\Utils\ApiConstructs\ApiResponseInterface
     */
    public function create(ApiRequestInterface $request, string $userId): ApiResponseInterface
    {
        $request->merge(['sender_id' => $userId]);

        if (null !== $errorResponse = $this->validateRequestAndRespond($request)) {
            return $errorResponse;
        }

        return $this->apiResponseFactory->createSuccess([]);
    }

    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'message_thread_id' => 'string|required|exists:message_threads,id',
            'message' => 'string|required|max:600',
            'receiver_id' => 'string|required|exists:users,id',
            'sender_id' => 'string|required|exists:users,id',
            'status' => 'string|required'
        ];
    }
}
