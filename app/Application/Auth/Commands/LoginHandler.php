<?php

declare(strict_types=1);

namespace App\Application\Auth\Commands;

use App\Domain\Auth\Repositories\AuthenticationServiceInterface;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserPassword;
use Illuminate\Auth\AuthenticationException;

class LoginHandler
{
    public function __construct(private AuthenticationServiceInterface $service) {}

    public function handle(LoginCommand $command): string
    {
        $user = $this->service->attempt(new UserEmail($command->loginData->email), new UserPassword($command->loginData->password));

        if (! $user) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        return $this->service->generateToken($user);
    }
}
