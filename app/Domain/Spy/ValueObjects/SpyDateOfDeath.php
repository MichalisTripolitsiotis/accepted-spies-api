<?php

declare(strict_types=1);

namespace App\Domain\Spy\ValueObjects;

use Carbon\Carbon;

final class SpyDateOfDeath
{
    public function __construct(private string $value) {}

    public function value(): string
    {
        return Carbon::parse($this->value)->toDateString();
    }
}
