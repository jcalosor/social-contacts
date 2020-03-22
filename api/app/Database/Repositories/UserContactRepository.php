<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Models\User;
use App\Database\Models\UserConnections;
use App\Database\Models\UserContact;
use App\Database\Repositories\Interfaces\UserContactRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class UserContactRepository extends AbstractRepository implements UserContactRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getContactsByStatus(string $userId, ?string $status = null): ?Collection
    {
        $query = $this->model->newQuery();

        $query
            ->from(\sprintf('%s as c', UserContact::TABLE_NAME))
            ->join(\sprintf('%s as u', User::TABLE_NAME), 'c.contacts_id', '=', 'u.id')
            ->join(\sprintf('%s as uc', UserConnections::TABLE_NAME), 'c.user_connections_id', '=', 'uc.id')
            ->where('c.users_id', $userId)
            ->select(['u.id', 'u.email', 'u.first_name', 'u.last_name', 'uc.status', 'uc.id as user_connections_id']);

        if ($status !== null && \array_key_exists($status, UserConnections::$statusMapper)) {
            $query->where('uc.status', $status);
        }

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return UserContact::class;
    }
}
