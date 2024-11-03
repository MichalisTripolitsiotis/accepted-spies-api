<?php

declare(strict_types=1);

namespace App\Domain\Spy\ValueObjects;

use InvalidArgumentException;

final class SpySortValueObject
{
    private array $sorts;

    private const ALLOWED_SORTS = ['full_name', 'date_of_birth', 'date_of_death'];

    public function __construct(array $sorts)
    {
        $this->validateSorts($sorts);
        $this->sorts = $sorts;
    }

    private function validateSorts(array $sorts): void
    {
        foreach ($sorts as $field => $direction) {
            if (! in_array($field, self::ALLOWED_SORTS)) {
                throw new InvalidArgumentException("Unsupported sort field: $field");
            }
            if (! in_array(strtolower($direction), ['asc', 'desc'])) {
                throw new InvalidArgumentException("Unsupported sort direction: $direction for field $field");
            }
        }
    }

    public function toArray(): array
    {
        return $this->sorts;
    }
}
