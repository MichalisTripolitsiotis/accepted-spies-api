<?php

declare(strict_types=1);

namespace App\Domain\Auth\ValueObjects;

use InvalidArgumentException;

final class UserEmail
{
    private $value;

    /**
     * UserEmail constructor.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = $email;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(string $email): void
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Invalid email.'
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
