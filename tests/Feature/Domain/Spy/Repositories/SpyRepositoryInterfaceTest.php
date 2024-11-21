<?php

namespace Tests\Feature\Domain\Spy\Repositories;

use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Infrastructure\Laravel\Models\AgencyModel;
use App\Infrastructure\Laravel\Models\SpyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Factories\SpyFactory;
use Tests\TestCase;

class SpyRepositoryInterfaceTest extends TestCase
{
    use RefreshDatabase;

    protected SpyRepositoryInterface $spyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->spyRepository = $this->app->make(SpyRepositoryInterface::class);
    }

    public function testCreateMethodCreatesSpyInDatabase(): void
    {
        $agency = AgencyModel::factory()->create();

        $spy = SpyFactory::create([
            'name' => 'Peter',
            'surname' => 'Doe',
            'agency' => [
                'name' => $agency->name,
                'id' => $agency->id,
            ],
            'country_of_operation' => 'Poland',
            'date_of_birth' => '1984-03-02',
        ]);

        $createdSpy = $this->spyRepository->create($spy);

        $this->assertDatabaseHas('spies', [
            'name' => 'Peter',
            'surname' => 'Doe',
            'country_of_operation' => 'Poland',
            'date_of_birth' => '1984-03-02',
            'date_of_death' => null,
        ]);

        $this->assertInstanceOf(Spy::class, $createdSpy);
    }

    public function testRandomEntriesReturnsCorrectNumberOfSpies(): void
    {
        SpyModel::factory()->count(10)->create();

        $randomSpies = $this->spyRepository->randomEntries(5);

        $this->assertCount(5, $randomSpies);
        foreach ($randomSpies as $spy) {
            $this->assertInstanceOf(Spy::class, $spy);
        }
    }

    public function testAllMethodReturnsAllSpies(): void
    {
        SpyModel::factory()->count(10)->create();

        $allSpies = $this->spyRepository->all();

        $this->assertCount(10, $allSpies->get());

        foreach ($allSpies as $spy) {
            $this->assertInstanceOf(SpyModel::class, $spy);
        }
    }
}
