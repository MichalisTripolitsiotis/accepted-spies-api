<?php

declare(strict_types=1);

namespace App\Application\Auth\Commands;

use App\Domain\Auth\Entities\User;

class LogoutCommand
{
    public function __construct(public User $user) {}
}
