<?php

declare(strict_types=1);

namespace App\Application\Agency\Handlers;

use App\Application\Agency\Commands\CreateAgencyCommand;
use App\Domain\Agency\Entities\Agency;
use App\Domain\Agency\Repositories\AgencyRepositoryInterface;
use App\Domain\Common\Bus\CommandHandler;

class CreateAgencyHandler extends CommandHandler
{
    public function __construct(private AgencyRepositoryInterface $repository) {}

    public function handle(CreateAgencyCommand $command): Agency
    {
        $agency = new Agency(
            $command->agencyData->name,
        );

        $this->repository->create($agency);

        return $agency;
    }
}
