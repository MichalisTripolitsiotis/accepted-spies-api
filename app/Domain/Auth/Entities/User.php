<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entities;

use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserEmailVerifiedDate;
use App\Domain\Auth\ValueObjects\UserName;
use App\Domain\Auth\ValueObjects\UserPassword;
use App\Domain\Auth\ValueObjects\UserRememberToken;

final class User
{
    public function __construct(
        private UserName $name,
        private UserEmail $email,
        private UserEmailVerifiedDate $emailVerifiedDate,
        private UserPassword $password,
        private UserRememberToken $rememberToken
    ) {}

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function emailVerifiedDate(): UserEmailVerifiedDate
    {
        return $this->emailVerifiedDate;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function rememberToken(): UserRememberToken
    {
        return $this->rememberToken;
    }

    public static function create(
        UserName $name,
        UserEmail $email,
        UserEmailVerifiedDate $emailVerifiedDate,
        UserPassword $password,
        UserRememberToken $rememberToken
    ): User {
        return new self($name, $email, $emailVerifiedDate, $password, $rememberToken);
    }
}
