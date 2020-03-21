<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\User;
use App\Database\Repositories\Interfaces\UserRepositoryInterface;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return User::class;
    }
}
