<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Bus;

use App\Domain\Common\Bus\Query;
use App\Domain\Common\Bus\QueryBus;
use Illuminate\Bus\Dispatcher;

class IlluminateQueryBus implements QueryBus
{
    public function __construct(
        protected Dispatcher $bus,
    ) {}

    public function ask(Query $query): mixed
    {
        return $this->bus->dispatch($query);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
