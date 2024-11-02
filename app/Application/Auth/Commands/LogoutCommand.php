<?php

declare(strict_types=1);

namespace App\Application\Auth\Commands;

use App\Domain\Auth\Entities\User;
use App\Domain\Common\Bus\Command;

class LogoutCommand extends Command
{
    public function __construct(public User $user) {}
}
