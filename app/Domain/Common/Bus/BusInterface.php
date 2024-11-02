<?php

namespace App\Domain\Common\Contracts;

use App\Domain\Common\Bus\Command;

interface BusInterface
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
