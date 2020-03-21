<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

abstract class AbstractEvent
{
    use SerializesModels;
}
