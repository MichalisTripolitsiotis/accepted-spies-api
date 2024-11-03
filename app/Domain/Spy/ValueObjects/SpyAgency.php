<?php

declare(strict_types=1);

namespace App\Domain\Spy\ValueObjects;

enum SpyAgency: string
{
    case CIA = 'CIA';
    case MI6 = 'MI6';
    case KGB = 'KGB';

    public function label(): SpyAgency
    {
        return $this;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromString(string $value): self
    {
        return self::tryFrom($value) ?? throw new \InvalidArgumentException("Invalid agency: $value");
    }
}
