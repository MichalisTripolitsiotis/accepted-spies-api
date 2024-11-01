<?php

declare(strict_types=1);

namespace App\Application\Spy\DTOs\Spy;

use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyDateOfDeath;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;

final readonly class CreateSpyData
{
    public function __construct(
        public SpyName $name,
        public SpySurname $surname,
        public SpyAgency $agency,
        public SpyCountryOfOperation $country,
        public SpyDateOfBirth $dateOfBirth,
        public ?SpyDateOfDeath $dateOfDeath = null
    ) {}

    public static function make(array $data): CreateSpyData
    {
        return new CreateSpyData(
            new SpyName($data['name']),
            new SpySurname($data['surname']),
            SpyAgency::fromString($data['agency']),
            new SpyCountryOfOperation($data['country']),
            new SpyDateOfBirth($data['date_of_birth']),
            isset($data['date_of_death']) ? new SpyDateOfDeath($data['date_of_death']) : null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name->value(),
            'surname' => $this->surname->value(),
            'agency' => $this->agency->value,
            'country' => $this->country->value(),
            'date_of_birth' => $this->dateOfBirth->value(),
            'date_of_death' => $this->dateOfDeath?->value(),
        ];
    }
}
