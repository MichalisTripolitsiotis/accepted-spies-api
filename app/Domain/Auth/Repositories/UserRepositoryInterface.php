<?php

declare(strict_types=1);

namespace App\Domain\Auth\Repositories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\UserEmail;

interface UserRepositoryInterface
{
    public function findByEmail(UserEmail $email): ?User;
}
