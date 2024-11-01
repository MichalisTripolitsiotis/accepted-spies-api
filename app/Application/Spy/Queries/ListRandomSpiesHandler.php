<?php

declare(strict_types=1);

namespace App\Application\Spy\Queries;

use App\Domain\Spy\Repositories\SpyRepositoryInterface;

class ListRandomSpiesHandler
{
    public function __construct(private SpyRepositoryInterface $repository) {}

    public function handle(ListRandomSpiesQuery $query): array
    {
        return $this->repository->randomEntries($query->getLimit());
    }
}
