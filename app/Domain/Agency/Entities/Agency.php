<?php

declare(strict_types=1);

namespace App\Domain\Agency\Entities;

use App\Domain\Agency\ValueObjects\AgencyId;
use App\Domain\Agency\ValueObjects\AgencyName;

final class Agency
{
    public function __construct(
        private AgencyName $name,
        private ?AgencyId $id = null,
    ) {}

    public function assignId(AgencyId $id): void
    {
        $this->id = $id;
    }

    public function id(): ?AgencyId
    {
        return $this->id;
    }

    public function name(): AgencyName
    {
        return $this->name;
    }
}
