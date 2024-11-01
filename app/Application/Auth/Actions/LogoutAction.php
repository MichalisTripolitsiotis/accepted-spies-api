<?php

namespace App\Application\Auth\Actions;

use App\Application\Auth\Commands\LogoutCommand;
use App\Application\Auth\Handlers\LogoutHandler;
use App\Domain\Auth\Entities\User;

class LogoutAction
{
    public function __construct(private LogoutHandler $handler) {}

    public function execute(User $user): void
    {
        $command = new LogoutCommand($user);
        $this->handler->handle($command);
    }
}
