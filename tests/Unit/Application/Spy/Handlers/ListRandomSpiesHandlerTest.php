<?php

namespace Tests\Unit\Application\Spy\Handlers;

use App\Application\Spy\Handlers\ListRandomSpiesHandler;
use App\Application\Spy\Queries\ListRandomSpiesQuery;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use Mockery;
use Tests\Factories\SpyFactory;
use Tests\TestCase;

class ListRandomSpiesHandlerTest extends TestCase
{
    protected $spyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->spyRepository = Mockery::mock(SpyRepositoryInterface::class);
    }

    public function testHandleReturnsRandomSpies(): void
    {
        $spy1 = SpyFactory::create([
            'name' => 'James',
            'surname' => 'Bond',
            'country_of_operation' => 'England',
            'date_of_birth' => '1953-03-18',
        ]);

        $spy2 = SpyFactory::create([
            'name' => 'Natasha',
            'surname' => 'Romanoff',
            'country_of_operation' => 'Russia',
            'date_of_birth' => '1984-11-22',
        ]);

        $randomSpies = [$spy1, $spy2];

        $query = new ListRandomSpiesQuery(5);

        $this->spyRepository->shouldReceive('randomEntries')
            ->once()
            ->with(5)
            ->andReturn($randomSpies);

        $handler = new ListRandomSpiesHandler($this->spyRepository);
        $spies = $handler->handle($query);

        $this->assertCount(2, $spies);
        $this->assertSame($randomSpies, $spies);
    }
}
