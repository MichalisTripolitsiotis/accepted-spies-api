<?php

declare(strict_types=1);

namespace App\Application\Spy\Commands;

use App\Domain\Common\Events\DomainEventDispatcher;
use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Events\SpyCreated;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;

class CreateSpyHandler
{
    public function __construct(private SpyRepositoryInterface $repository, private DomainEventDispatcher $eventDispatcher) {}

    public function handle(CreateSpyCommand $command): Spy
    {
        $spy = new Spy(
            $command->spyData->name,
            $command->spyData->surname,
            $command->spyData->agency,
            $command->spyData->country,
            $command->spyData->dateOfBirth,
            $command->spyData->dateOfDeath
        );

        $this->repository->create($spy);

        $this->eventDispatcher->dispatch(new SpyCreated($spy));

        return $spy;
    }
}
