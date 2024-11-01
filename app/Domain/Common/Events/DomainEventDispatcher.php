<?php

namespace App\Domain\Common\Events;

interface DomainEventDispatcher
{
    public function dispatch(DomainEvent $event): void;
}
