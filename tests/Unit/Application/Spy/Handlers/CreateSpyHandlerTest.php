<?php

namespace Tests\Unit\Application\Spy\Handlers;

use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\Commands\CreateSpyHandler;
use App\Application\Spy\DTOs\Spy\CreateSpyData;
use App\Domain\Spy\Events\SpyCreated;
use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateSpyHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function testSpyCreatedEventIsDispatched()
    {
        Event::fake();

        $handler = $this->app->make(CreateSpyHandler::class);

        $spyData = new CreateSpyData(
            new SpyName('John'),
            new SpySurname('Doe'),
            SpyAgency::fromString('CIA'),
            new SpyCountryOfOperation('USA'),
            new SpyDateOfBirth('1980-01-01')
        );

        $command = new CreateSpyCommand($spyData);

        $handler->handle($command);

        Event::assertDispatched(SpyCreated::class);
    }
}
