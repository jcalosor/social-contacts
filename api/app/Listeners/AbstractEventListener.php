<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\AbstractEvent;

abstract class AbstractListener
{
    /**
     * Handle the abstract event.
     *
     * @param \App\Events\AbstractEvent $event
     */
    abstract public function handle(AbstractEvent $event): void;
}
