<?php

declare(strict_types=1);

namespace App\Application\Spy\Commands;

use App\Application\Spy\DTOs\CreateSpyData;
use App\Domain\Common\Bus\Command;

class CreateSpyCommand extends Command
{
    public function __construct(public CreateSpyData $spyData) {}
}
