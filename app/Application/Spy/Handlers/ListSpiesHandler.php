<?php

declare(strict_types=1);

namespace App\Application\Spy\Handlers;

use App\Application\Spy\Queries\ListSpiesQuery;
use App\Application\Spy\Services\SpyFilterService;
use App\Domain\Common\Bus\QueryHandler;

class ListSpiesHandler extends QueryHandler
{
    public function __construct(private SpyFilterService $spyService) {}

    public function handle(ListSpiesQuery $query): mixed
    {
        return $this->spyService->getFilteredSpies($query->getParameters());
    }
}
