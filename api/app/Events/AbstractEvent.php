<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

abstract class AbstractEvent
{
    use SerializesModels;

    /**
     * Return the required parameters to resolve the event object.
     *
     * @return mixed[]
     */
    abstract public function getParameters(): array;

    /**
     * Return the required primary key to resolve the event object,
     * this assumes that the primary key is in a string format ie: `guid`
     *
     * @return string
     */
    abstract public function getPrimaryKey(): string;
}
