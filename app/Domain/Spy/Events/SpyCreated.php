<?php

declare(strict_types=1);

namespace App\Domain\Spy\Events;

use App\Domain\Common\Events\DomainEvent;
use App\Domain\Spy\Entities\Spy;

class SpyCreated implements DomainEvent
{
    public function __construct(public Spy $spy) {}
}
