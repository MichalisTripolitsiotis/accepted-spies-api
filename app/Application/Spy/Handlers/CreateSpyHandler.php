<?php

declare(strict_types=1);

namespace App\Application\Spy\Handlers;

use App\Application\Spy\Commands\CreateSpyCommand;
use App\Domain\Agency\Repositories\AgencyRepositoryInterface;
use App\Domain\Common\Bus\CommandHandler;
use App\Domain\Common\Events\DomainEventDispatcher;
use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Events\SpyCreated;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;

class CreateSpyHandler extends CommandHandler
{
    public function __construct(private SpyRepositoryInterface $repository, private DomainEventDispatcher $eventDispatcher, private AgencyRepositoryInterface $agencyRepository) {}

    public function handle(CreateSpyCommand $command): Spy
    {
        $agency = $this->agencyRepository->findById($command->spyData->agency);

        if (! $agency) {
            throw new \InvalidArgumentException("Invalid Agency ID.");
        }

        $spy = new Spy(
            $command->spyData->name,
            $command->spyData->surname,
            $agency,
            $command->spyData->country,
            $command->spyData->dateOfBirth,
            $command->spyData->dateOfDeath
        );

        $this->repository->create($spy);

        $this->eventDispatcher->dispatch(new SpyCreated($spy));

        return $spy;
    }
}
