<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\UserConnections;
use App\Database\Repositories\Interfaces\UserConnectionRepositoryInterface;

final class UserConnectionRepository extends AbstractRepository implements UserConnectionRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return UserConnections::class;
    }
}
