<?php

declare(strict_types=1);

namespace App\Application\Agency\Services;

use App\Domain\Agency\Repositories\AgencyRepositoryInterface;
use App\Domain\Common\DTOs\QueryParametersDTO;

class AgencyFilterService
{
    public function __construct(private AgencyRepositoryInterface $repository) {}

    public function getAgencies(QueryParametersDTO $options): mixed
    {
        $query = $this->repository->all();

        $query->with('spies');

        return $query->paginate($options->perPage, ['*'], 'page', $options->page);
    }
}
