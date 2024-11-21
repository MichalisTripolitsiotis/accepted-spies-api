<?php

namespace App\Application\Agency\DTOs;

use App\Domain\Agency\Entities\Agency;

final readonly class AgencyResponse
{
    public function __construct(private Agency $agency) {}

    public function toArray(): array
    {
        return [
            'id' => $this->agency->id()->value(),
            'name' => $this->agency->name()->value(),
        ];
    }
}
