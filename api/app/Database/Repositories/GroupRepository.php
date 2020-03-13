<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\Group;
use App\Database\Repositories\Interfaces\GroupRepositoryInterface;
use Unostentatious\Repository\AbstractEloquentRepository;

final class GroupRepository extends AbstractEloquentRepository implements GroupRepositoryInterface
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Group::class;
    }
}
