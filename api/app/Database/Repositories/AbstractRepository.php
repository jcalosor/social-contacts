<?php
declare(strict_types=1);

namespace App\Database\Repositories;

use App\Database\Repositories\Interfaces\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Unostentatious\Repository\AbstractEloquentRepository;

abstract class AbstractRepository extends AbstractEloquentRepository implements AbstractRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findBy(array $attributes): Collection
    {
        $query = $this->model->newQuery();

        foreach ($attributes as $column => $value) {
            $query->where(Str::snake($column), '=', $value);
        }

        //Log::debug($query->toSql());
        /** @var \Illuminate\Database\Eloquent\Collection $result */
        $result = $query->get();

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $attributes): ?Model
    {
        /** @var \Illuminate\Database\Eloquent\Collection $result */
        $result = $this->findBy($attributes);

        return $result->first();
    }
}
