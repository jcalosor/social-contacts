<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use Unostentatious\Repository\AbstractEloquentRepository;

final class UserContactRepository extends AbstractEloquentRepository implements UserContactRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return UserContact::class;
    }
}
