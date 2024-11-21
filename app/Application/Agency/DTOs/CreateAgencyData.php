<?php

declare(strict_types=1);

namespace App\Application\Agency\DTOs;

use App\Domain\Agency\ValueObjects\AgencyName;

final readonly class CreateAgencyData
{
    public function __construct(
        public AgencyName $name
    ) {}

    public static function make(array $data): CreateAgencyData
    {
        return new CreateAgencyData(
            new AgencyName($data['name'])
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name->value(),
        ];
    }
}
