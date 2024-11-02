<?php

namespace App\Domain\Common\Bus;

interface CommandBus
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
