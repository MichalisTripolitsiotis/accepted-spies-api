<?php

declare(strict_types=1);

namespace App\Application\Spy\DTOs;

use App\Application\Agency\DTOs\AgencyResponse;
use App\Domain\Spy\Entities\Spy;

final readonly class SpyResponse
{
    public function __construct(private Spy $spy) {}

    public function toArray(): array
    {
        return [
            'id' => $this->spy->id()->value(),
            'name' => $this->spy->name()->value(),
            'surname' => $this->spy->surname()->value(),
            'agency' => (new AgencyResponse($this->spy->agency()))->toArray(),
            'country_of_operation' => $this->spy->countryOfOperation()->value(),
            'date_of_birth' => $this->spy->dateOfBirth()->value(),
            'date_of_death' => $this->spy->dateOfDeath()?->value(),
        ];
    }
}
