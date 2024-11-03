<?php

declare(strict_types=1);

namespace App\Domain\Spy\ValueObjects;

use InvalidArgumentException;

final class SpyFilterValueObject
{
    private array $filters;

    private const ALLOWED_FILTERS = ['name', 'surname', 'exact_age', 'age_min', 'age_max'];

    public function __construct(array $filters)
    {
        $this->validateFilters($filters);
        $this->filters = $filters;
    }

    private function validateFilters(array $filters): void
    {
        $unsupportedFilters = array_diff(array_keys($filters), self::ALLOWED_FILTERS);
        if (! empty($unsupportedFilters)) {
            throw new InvalidArgumentException('Unsupported filters: '.implode(', ', $unsupportedFilters));
        }
    }

    public function toArray(): array
    {
        return $this->filters;
    }
}
