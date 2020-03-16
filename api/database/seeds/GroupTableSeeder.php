<?php
declare(strict_types=1);

final class GroupTableSeeder extends AbstractSeeder
{
    /**
     * How many set of records should be created.
     *
     * @return int
     */
    public function getInsertCount(): int
    {
        return 5;
    }

    /**
     * Returns the model named being seeded.
     *
     * @return string
     */
    public function getModelClass(): string
    {
        return \App\Database\Models\Group::class;
    }
}
