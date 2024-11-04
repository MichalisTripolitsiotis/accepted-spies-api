<?php

namespace Tests\Unit\Application\Spy\Handlers;

use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\DTOs\CreateSpyData;
use App\Application\Spy\Handlers\CreateSpyHandler;
use App\Domain\Common\Events\DomainEventDispatcher;
use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Events\SpyCreated;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Domain\Spy\ValueObjects\SpyAgency;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;
use Mockery;
use Tests\TestCase;

class CreateSpyHandlerTest extends TestCase
{
    protected $spyRepository;

    protected $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spyRepository = Mockery::mock(SpyRepositoryInterface::class);
        $this->eventDispatcher = Mockery::mock(DomainEventDispatcher::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testHandleCreatesSpyAndDispatchesEvent(): void
    {
        $spyData = new CreateSpyData(
            new SpyName('Alex'),
            new SpySurname('Doe'),
            SpyAgency::fromString('CIA'),
            new SpyCountryOfOperation('USA'),
            new SpyDateOfBirth('1953-03-18'),
        );

        $createSpyCommand = new CreateSpyCommand($spyData);

        $this->spyRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($spy) use ($spyData) {
                return $spy instanceof Spy &&
                    $spy->name()->value() === $spyData->name->value() &&
                    $spy->surname()->value() === $spyData->surname->value();
            }));

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Mockery::type(SpyCreated::class))
            ->andReturnUsing(function ($event) {
                return $event;
            });

        $handler = new CreateSpyHandler($this->spyRepository, $this->eventDispatcher);

        $createdSpy = $handler->handle($createSpyCommand);

        $this->assertInstanceOf(Spy::class, $createdSpy);
        $this->assertEquals('Alex', $createdSpy->name()->value());
        $this->assertEquals('Doe', $createdSpy->surname()->value());

        $this->eventDispatcher->shouldHaveReceived('dispatch')
            ->once()
            ->with(Mockery::type(SpyCreated::class));
    }
}
