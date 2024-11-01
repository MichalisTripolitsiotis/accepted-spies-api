<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Repositories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserEmailVerifiedDate;
use App\Domain\Auth\ValueObjects\UserName;
use App\Domain\Auth\ValueObjects\UserPassword;
use App\Domain\Auth\ValueObjects\UserRememberToken;
use App\Infrastructure\Laravel\Models\UserModel;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(UserEmail $email): ?User
    {
        $userModel = UserModel::where('email', $email->value())->first();

        if (! $userModel) {
            return null;
        }

        return new User(
            new UserName($userModel->name),
            new UserEmail($userModel->email),
            new UserEmailVerifiedDate($userModel->email_verified_at),
            new UserPassword($userModel->password),
            new UserRememberToken($userModel->remember_token)
        );
    }
}
