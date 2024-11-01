<?php

declare(strict_types=1);

namespace App\Application\Spy\Commands;

use App\Application\Spy\DTOs\CreateSpyData;

class CreateSpyCommand
{
    public function __construct(public CreateSpyData $spyData) {}
}
