<?php

namespace App\Application\Agency\Handlers;

use App\Application\Agency\Queries\ListAgenciesQuery;
use App\Application\Agency\Services\AgencyFilterService;
use App\Domain\Common\Bus\QueryHandler;

class ListAgenciesHandler extends QueryHandler
{
    public function __construct(private AgencyFilterService $agencyService) {}

    public function handle(ListAgenciesQuery $query): mixed
    {
        return $this->agencyService->getAgencies($query->getParameters());
    }
}
