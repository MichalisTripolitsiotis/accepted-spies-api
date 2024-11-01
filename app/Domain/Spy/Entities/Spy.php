<?php

declare(strict_types=1);

namespace App\Domain\Spy\Entities;

use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyDateOfDeath;
use App\Domain\Spy\ValueObjects\SpyId;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;

final class Spy
{
    public function __construct(
        private SpyName $name,
        private SpySurname $surname,
        private SpyAgency $agency,
        private SpyCountryOfOperation $country,
        private SpyDateOfBirth $dateOfBirth,
        private ?SpyDateOfDeath $dateOfDeath = null,
        private ?SpyId $id = null,
    ) {}

    public function assignId(SpyId $id): void
    {
        $this->id = $id;
    }

    public function id(): SpyId
    {
        return $this->id;
    }

    public function name(): SpyName
    {
        return $this->name;
    }

    public function surname(): SpySurname
    {
        return $this->surname;
    }

    public function agency(): SpyAgency
    {
        return $this->agency;
    }

    public function countryOfOperation(): SpyCountryOfOperation
    {
        return $this->country;
    }

    public function dateOfBirth(): SpyDateOfBirth
    {
        return $this->dateOfBirth;
    }

    public function dateOfDeath(): ?SpyDateOfDeath
    {
        return $this->dateOfDeath;
    }

    public static function create(
        SpyName $name,
        SpySurname $surname,
        SpyAgency $agency,
        SpyCountryOfOperation $countryOfOperation,
        SpyDateOfBirth $dateOfBirth,
        ?SpyDateOfDeath $dateOfDeath = null
    ): Spy {
        return new self($name, $surname, $agency, $countryOfOperation, $dateOfBirth, $dateOfDeath);
    }
}
