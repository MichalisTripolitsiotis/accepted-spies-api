<?php

namespace Tests\Factories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserEmailVerifiedDate;
use App\Domain\Auth\ValueObjects\UserName;
use App\Domain\Auth\ValueObjects\UserPassword;
use App\Domain\Auth\ValueObjects\UserRememberToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory
{
    public static function create(array $attributes = []): User
    {
        return new User(
            new UserName($attributes['name'] ?? 'Test User'),
            new UserEmail($attributes['email'] ?? 'test@example.com'),
            new UserEmailVerifiedDate($attributes['email_verified_at'] ?? now()),
            new UserPassword($attributes['password'] ?? Hash::make('password')),
            new UserRememberToken($attributes['remember_token'] ?? Str::random(10))
        );
    }
}
