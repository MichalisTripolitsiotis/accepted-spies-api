<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Events;

use App\Domain\Common\Events\DomainEvent;
use App\Domain\Common\Events\DomainEventDispatcher;
use Illuminate\Contracts\Events\Dispatcher as LaravelDispatcher;

class LaravelEventDispatcher implements DomainEventDispatcher
{
    private LaravelDispatcher $dispatcher;

    public function __construct(LaravelDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
