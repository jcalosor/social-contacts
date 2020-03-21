<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use App\Services\Validator\Interfaces\ValidatorInterface;
use Illuminate\Contracts\Events\Dispatcher;

abstract class AbstractDispatchController extends AbstractController
{
    /**
     * Instance of the illuminate dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * AbstractDispatchController constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     * @param \App\Services\Validator\Interfaces\ValidatorInterface $validator
     */
    public function __construct(
        ApiResponseFactoryInterface $apiResponseFactory,
        Dispatcher $dispatcher,
        TranslatorInterface $translator,
        ValidatorInterface $validator
    ) {
        parent::__construct($apiResponseFactory, $translator, $validator);

        $this->dispatcher = $dispatcher;
    }

    /**
     * Get the event class specified in the controller.
     *
     * @return string
     */
    abstract protected function getEventClass(): string;

    /**
     * Get the event parameters required by the event.
     *
     * @return mixed[]
     */
    abstract protected function getEventParameters(): array;

    /**
     * Dispatch the specified event inside the controller.
     *
     * @param string $primaryKey
     *
     * @return bool
     */
    protected function dispatchEvent(string $primaryKey): bool
    {
        $event = $this->getEventClass();

        return $this->dispatcher->dispatch(new $event($primaryKey, $this->getEventParameters())) === null;
    }
}
