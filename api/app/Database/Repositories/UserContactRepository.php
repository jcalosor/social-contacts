<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;

final class UserContactRepository extends AbstractRepository implements UserContactRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return UserContact::class;
    }
}
