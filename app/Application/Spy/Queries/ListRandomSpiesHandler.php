<?php

declare(strict_types=1);

namespace App\Application\Spy\Queries;

use App\Domain\Common\Bus\QueryHandler;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;

class ListRandomSpiesHandler extends QueryHandler
{
    public function __construct(private SpyRepositoryInterface $repository) {}

    public function handle(ListRandomSpiesQuery $query): array
    {
        return $this->repository->randomEntries($query->getLimit());
    }
}
