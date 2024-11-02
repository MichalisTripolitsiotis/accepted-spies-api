<?php

declare(strict_types=1);

namespace App\Application\Auth\Commands;

use App\Domain\Auth\Repositories\AuthenticationServiceInterface;
use App\Domain\Common\Bus\CommandHandler;

class LogoutHandler extends CommandHandler
{
    public function __construct(private AuthenticationServiceInterface $service) {}

    public function handle(LogoutCommand $command): void
    {
        $this->service->revokeTokens($command->user);
    }
}
