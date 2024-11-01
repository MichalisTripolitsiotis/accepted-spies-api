<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Services;

use App\Domain\Auth\Repositories\AuthenticationServiceInterface;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserPassword;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Support\Facades\Auth;

class SanctumAuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function attempt(UserEmail $email, UserPassword $password): ?User
    {
        $credentials = [
            'email' => $email->value(),
            'password' => $password->value(),
        ];

        if (Auth::attempt($credentials)) {
            return $this->userRepository->findByEmail($email);
        }

        return null;
    }

    public function generateToken(User $user): string
    {
        // Note: I feel that Sanctum is tightly coupled with Eloquent so maybe it makes sense to use the actual UserModel here.
        $userModel = UserModel::where('email', $user->email()->value())->firstOrFail();

        return $userModel->createToken('auth_token')->plainTextToken;
    }

    public function revokeTokens(User $user): bool
    {
        $userModel = UserModel::where('email', $user->email()->value())->firstOrFail();

        return $userModel->tokens()->delete() == 1 ? true : false;
    }
}
