<?php

namespace App\Domain\Agency\Repositories;

use App\Domain\Agency\Entities\Agency;
use App\Domain\Agency\ValueObjects\AgencyId;

interface AgencyRepositoryInterface
{
    public function findById(AgencyId $id): ?Agency;

    public function create(Agency $agency): ?Agency;

    public function all(): mixed;
}
