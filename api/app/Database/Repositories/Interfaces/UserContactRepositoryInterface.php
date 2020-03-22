<?php
declare(strict_types=1);

namespace App\Database\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserContactRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * Get the contacts that belongs to the provided user with it's corresponding status.
     *
     * @param string $userId
     * @param null|string $status
     *
     * @return null|\Illuminate\Database\Eloquent\Collection
     */
    public function getContactsByStatus(string $userId, ?string $status = null): ?Collection;
}
