<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\Messages;
use App\Database\Repositories\Interfaces\MessageRepositoryInterface;

final class MessageRepository extends AbstractRepository implements MessageRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Messages::class;
    }
}
