<?php

declare(strict_types=1);

namespace App\Application\Auth\DTOs;

final readonly class LoginData
{
    public function __construct(public string $email, public string $password) {}

    public static function make(array $data): LoginData
    {
        return new LoginData($data['email'], $data['password']);
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
