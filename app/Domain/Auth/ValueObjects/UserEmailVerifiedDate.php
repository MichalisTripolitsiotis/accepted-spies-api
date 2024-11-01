<?php

declare(strict_types=1);

namespace App\Domain\Auth\ValueObjects;

use DateTime;

final class UserEmailVerifiedDate
{
    private $value;

    public function __construct(?DateTime $emailVerifiedDate)
    {
        $this->value = $emailVerifiedDate;
    }

    public function value(): ?DateTime
    {
        return $this->value;
    }
}
