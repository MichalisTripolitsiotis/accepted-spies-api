<?php

namespace App\Application\Auth\Actions;

use App\Application\Auth\Commands\LoginCommand;
use App\Application\Auth\DTOs\LoginData;
use App\Application\Auth\Handlers\LoginHandler;

class LoginAction
{
    public function __construct(private LoginHandler $handler) {}

    public function execute(LoginData $data): string
    {
        $command = new LoginCommand($data);
        return $this->handler->handle($command);
    }
}
