<?php

namespace App\Domain\Common\Contracts;

interface BusInterface
{
    public function dispatch(object $command);
}
