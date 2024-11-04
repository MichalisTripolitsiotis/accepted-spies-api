<?php

declare(strict_types=1);

namespace App\Domain\Common\Events;

interface DomainEventDispatcher
{
    public function dispatch(DomainEvent $event): void;
}
