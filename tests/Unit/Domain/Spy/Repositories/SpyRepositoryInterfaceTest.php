<?php

namespace Tests\Unit\Domain\Spy\Repositories;

use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Domain\Spy\ValueObjects\SpyId;
use Mockery;
use Tests\Factories\SpyFactory;
use Tests\TestCase;

class SpyRepositoryInterfaceTest extends TestCase
{
    protected $spyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->spyRepository = Mockery::mock(SpyRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreateMethodWithSpyEntity(): void
    {
        $spy = SpyFactory::create([
            'name' => 'James',
            'surname' => 'Bond',
        ]);

        $this->spyRepository->shouldReceive('create')
            ->once()
            ->with($spy)
            ->andReturnUsing(function ($spy) {
                // TODO: A workaround as I think due to mocking, it doesn't run the assign id function.
                $spy->assignId(new SpyId(1));

                return $spy;
            });

        $createdSpy = $this->spyRepository->create($spy);

        $this->assertNotNull($createdSpy->id());
        $this->assertEquals(1, $createdSpy->id()->value());
    }

    public function testRandomEntriesReturnsSpies(): void
    {
        $spies = [
            SpyFactory::create(['name' => 'James', 'surname' => 'Bond']),
            SpyFactory::create(['name' => 'Jane', 'surname' => 'Doe']),
        ];

        $this->spyRepository->shouldReceive('randomEntries')
            ->once()
            ->with(2)
            ->andReturn($spies);

        $result = $this->spyRepository->randomEntries(2);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Spy::class, $result[0]);
        $this->assertInstanceOf(Spy::class, $result[1]);
        $this->assertEquals('James', $result[0]->name()->value());
        $this->assertEquals('Bond', $result[0]->surname()->value());
    }

    public function testAllMethodReturnsSpies(): void
    {
        $spies = [
            SpyFactory::create(['name' => 'James', 'surname' => 'Bond']),
            SpyFactory::create(['name' => 'Jane', 'surname' => 'Doe']),
        ];

        $this->spyRepository->shouldReceive('all')
            ->once()
            ->andReturn($spies);

        $result = $this->spyRepository->all();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Spy::class, $result[0]);
        $this->assertInstanceOf(Spy::class, $result[1]);
        $this->assertEquals('James', $result[0]->name()->value());
        $this->assertEquals('Bond', $result[0]->surname()->value());
    }
}
