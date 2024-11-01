<?php

declare(strict_types=1);

namespace App\Application\Spy\DTOs;

use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyDateOfDeath;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;

final readonly class CreateSpyData
{
    public SpyName $name;
    public SpySurname $surname;
    public SpyAgency $agency;
    public SpyCountryOfOperation $country;
    public SpyDateOfBirth $dateOfBirth;
    public SpyDateOfDeath $dateOfDeath;

    public function __construct(array $data)
    {
        $this->name = new SpyName($data['name']);
        $this->surname = new SpySurname($data['surname']);
        $this->agency = SpyAgency::fromString($data['agency']);
        $this->country = new SpyCountryOfOperation($data['country']);
        $this->dateOfBirth = new SpyDateOfBirth($data['date_of_birth']);
        $this->dateOfDeath = isset($data['date_of_death']) ? new SpyDateOfDeath($data['date_of_death']) : null;
    }
}
