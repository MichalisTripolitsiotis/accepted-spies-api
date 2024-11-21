<?php

namespace App\Application\Agency\Commands;

use App\Application\Agency\DTOs\CreateAgencyData;
use App\Domain\Common\Bus\Command;

class CreateAgencyCommand extends Command
{
    public function __construct(public CreateAgencyData $agencyData) {}
}
