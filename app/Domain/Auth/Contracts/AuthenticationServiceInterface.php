<?php

declare(strict_types=1);

namespace App\Domain\Auth\Contracts;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserPassword;

interface AuthenticationServiceInterface
{
    public function attempt(UserEmail $email, UserPassword $password): ?User;

    public function generateToken(User $user): string;

    public function revokeTokens(User $user): bool;
}
