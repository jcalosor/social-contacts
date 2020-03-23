<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\MessageThreads;
use App\Database\Repositories\Interfaces\MessageThreadRepositoryInterface;

final class MessageThreadRepository extends AbstractRepository implements MessageThreadRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return MessageThreads::class;
    }
}
