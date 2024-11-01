<?php

declare(strict_types=1);

namespace App\Application\Spy\DTOs\Spy;

use App\Domain\Spy\Entities\Spy;

final readonly class SpyResponse
{
    private Spy $spy;

    public function __construct(Spy $spy)
    {
        $this->spy = $spy;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->spy->id()->value(),
            'name' => $this->spy->name()->value(),
            'surname' => $this->spy->surname()->value(),
            'agency' => $this->spy->agency()->value,
            'country_of_operation' => $this->spy->countryOfOperation()->value(),
            'date_of_birth' => $this->spy->dateOfBirth()->value(),
            'date_of_death' => $this->spy->dateOfDeath()?->value(),
        ];
    }
}
