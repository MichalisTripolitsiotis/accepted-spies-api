<?php

namespace App\Application\Agency\Handlers;

use App\Application\Agency\Queries\AgencyQuery;
use App\Domain\Agency\Repositories\AgencyRepositoryInterface;
use App\Domain\Agency\ValueObjects\AgencyId;
use App\Domain\Common\Bus\QueryHandler;

class AgencyQueryHandler extends QueryHandler
{
    public function __construct(private AgencyRepositoryInterface $repository) {}

    public function handle(AgencyQuery $query): mixed
    {
        $id = new AgencyId($query->getId());

        return $this->repository->findById($id);
    }
}
