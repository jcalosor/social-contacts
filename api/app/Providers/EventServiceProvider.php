<?php /** @noinspection PhpMissingFieldTypeInspection */
declare(strict_types=1);

namespace App\Providers;

use App\Events\MessagesEvent;
use App\Events\UserContactsEvent;
use App\Listeners\CreateMessagesListener;
use App\Listeners\CreateUserContactsListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MessagesEvent::class => [CreateMessagesListener::class],
        UserContactsEvent::class => [CreateUserContactsListener::class]
    ];
}
