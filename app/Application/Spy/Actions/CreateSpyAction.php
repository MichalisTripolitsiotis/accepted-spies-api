<?php

declare(strict_types=1);

namespace App\Application\Spy\Actions;

use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\DTOs\CreateSpyData;
use App\Application\Spy\Handlers\CreateSpyHandler;
use App\Domain\Spy\Entities\Spy;

class CreateSpyAction
{
    public function __construct(private CreateSpyHandler $handler) {}

    public function execute(CreateSpyData $data): Spy
    {
        $command = new CreateSpyCommand($data);

        return $this->handler->handle($command);
    }
}
