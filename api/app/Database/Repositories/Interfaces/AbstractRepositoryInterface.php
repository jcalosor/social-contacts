<?php
declare(strict_types=1);

namespace App\Database\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Unostentatious\Repository\Interfaces\ModelRepositoryInterface;

interface AbstractRepositoryInterface extends ModelRepositoryInterface
{
    /**
     * Find a collection of models by given [column => value] attributes, then return a collection of result.
     *
     * @param mixed[] $attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBy(array $attributes): Collection;

    /**
     * Find a model by given [column => value] attributes, then return a model.
     *
     * @param mixed[] $attributes
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function findOneBy(array $attributes): ?Model;
}
