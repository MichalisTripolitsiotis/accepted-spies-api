<?php

declare(strict_types=1);

namespace App\Application\Auth\Handlers;

use App\Application\Auth\Commands\LoginCommand;
use App\Domain\Auth\Contracts\AuthenticationServiceInterface;
use App\Domain\Common\Bus\CommandHandler;
use Illuminate\Auth\AuthenticationException;

class LoginHandler extends CommandHandler
{
    public function __construct(private AuthenticationServiceInterface $service) {}

    public function handle(LoginCommand $command): string
    {
        $user = $this->service->attempt($command->loginData->email, $command->loginData->password);

        if (! $user) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        return $this->service->generateToken($user);
    }
}
