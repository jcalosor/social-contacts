<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Database\Repositories\Interfaces\GroupRepositoryInterface;

final class GroupController extends AbstractController
{
    private GroupRepositoryInterface $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function create()
    {
    }
}
