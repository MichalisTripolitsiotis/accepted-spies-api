<?php

namespace Tests\Factories;

use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyDateOfDeath;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;

class SpyFactory
{
    public static function create(array $attributes = []): Spy
    {
        return new Spy(
            new SpyName($attributes['name'] ?? 'James'),
            new SpySurname($attributes['surname'] ?? 'Bond'),
            SpyAgency::fromString($attributes['agency'] ?? 'MI6'),
            new SpyCountryOfOperation($attributes['country_of_operation'] ?? 'England'),
            new SpyDateOfBirth($attributes['date_of_birth'] ?? '1920-11-11'),
            isset($attributes['date_of_death']) ? new SpyDateOfDeath($attributes['date_of_death']) : null
        );
    }
}
