<?php

namespace App\Domain\Agency\ValueObjects;

class AgencyName
{
    public function __construct(private string $value) {}

    public function value(): string
    {
        return $this->value;
    }
}
