<?php

declare(strict_types=1);

namespace App\Domain\Spy\ValueObjects;

final class SpySurname
{
    public function __construct(private string $value) {}

    public function value(): string
    {
        return $this->value;
    }
}
