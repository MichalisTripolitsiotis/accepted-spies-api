<?php

namespace Tests\Factories;

use App\Domain\Agency\Entities\Agency;
use App\Domain\Agency\ValueObjects\AgencyId;
use App\Domain\Agency\ValueObjects\AgencyName;

class AgencyFactory
{
    public static function create(array $attributes = []): Agency
    {
        return new Agency(
            new AgencyName($attributes['name'] ?? 'MI6'),
            new AgencyId($attributes['id'] ?? 1),
        );
    }
}
