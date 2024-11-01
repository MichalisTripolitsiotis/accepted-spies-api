<?php

declare(strict_types=1);

namespace App\Domain\Auth\ValueObjects;

final class UserPassword
{
    private $value;

    public function __construct(string $password)
    {
        $this->value = $password;
    }

    public function value(): string
    {
        return $this->value;
    }
}
