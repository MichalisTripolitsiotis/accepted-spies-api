<?php

declare(strict_types=1);

namespace App\Application\Auth\DTOs;

use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserPassword;

final readonly class LoginData
{
    public function __construct(public UserEmail $email, public UserPassword $password) {}

    public static function make(array $data): LoginData
    {
        return new LoginData(new UserEmail($data['email']), new UserPassword($data['password']));
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
