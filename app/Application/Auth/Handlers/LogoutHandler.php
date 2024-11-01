<?php

declare(strict_types=1);

namespace App\Application\Auth\Handlers;

use App\Application\Auth\Commands\LogoutCommand;
use App\Domain\Auth\Repositories\AuthenticationServiceInterface;

class LogoutHandler
{
    public function __construct(private AuthenticationServiceInterface $service) {}

    public function handle(LogoutCommand $command): void
    {
        $this->service->revokeTokens($command->user);
    }
}
