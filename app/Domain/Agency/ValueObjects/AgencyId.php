<?php

declare(strict_types=1);

namespace App\Domain\Agency\ValueObjects;

use InvalidArgumentException;

final class AgencyId
{
    private $value;

    public function __construct(int $id)
    {
        $this->validate($id);
        $this->value = $id;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(int $id): void
    {
        if (! filter_var($id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('Invalid user id.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
