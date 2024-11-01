<?php

declare(strict_types=1);

namespace App\Application\Auth\Commands;

use App\Application\Auth\DTOs\LoginData;

class LoginCommand
{
    public function __construct(public LoginData $loginData) {}
}
