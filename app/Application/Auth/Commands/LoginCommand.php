<?php

declare(strict_types=1);

namespace App\Application\Auth\Commands;

use App\Application\Auth\DTOs\LoginData;
use App\Domain\Common\Bus\Command;

class LoginCommand extends Command
{
    public function __construct(public LoginData $loginData) {}
}
