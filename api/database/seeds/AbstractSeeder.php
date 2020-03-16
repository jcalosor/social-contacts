<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;

abstract class AbstractSeeder extends Seeder
{
    /**
     * How many set of records should be created.
     *
     * @return int
     */
    abstract public function getInsertCount(): int;

    /**
     * Returns the model named being seeded.
     *
     * @return string
     */
    abstract public function getModelClass(): string;

    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run(): void
    {
        factory($this->getModelClass(), $this->getInsertCount())->create();
    }
}
