<?php

namespace Tests\Unit\Application\Spy\Handlers;

use App\Application\Spy\Handlers\ListSpiesHandler;
use App\Application\Spy\Queries\ListSpiesQuery;
use App\Application\Spy\Services\SpyFilterService;
use App\Domain\Common\DTOs\QueryParametersDTO;
use App\Domain\Spy\ValueObjects\SpyFilterValueObject;
use App\Domain\Spy\ValueObjects\SpySortValueObject;
use Mockery;
use Tests\Factories\SpyFactory;
use Tests\TestCase;

class ListSpiesHandlerTest extends TestCase
{
    protected $spyService;

    protected $spies;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spyService = Mockery::mock(SpyFilterService::class);

        $this->spies = collect([
            SpyFactory::create([
                'name' => 'John',
                'surname' => 'Doe',
                'agency' => 'CIA',
                'country_of_operation' => 'USA',
                'date_of_birth' => '1985-01-01',
            ]),

            SpyFactory::create([
                'name' => 'Jane',
                'surname' => 'Smith',
                'agency' => 'MI6',
                'country_of_operation' => 'England',
                'date_of_birth' => '1990-05-15',
                'date_of_death' => '2022-05-15',
            ]),

            SpyFactory::create([
                'name' => 'James',
                'surname' => 'Bond',
                'agency' => 'MI6',
                'country_of_operation' => 'England',
                'date_of_birth' => '1953-03-18',
            ]),
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testHandleWithoutFiltersOrSorting()
    {
        $filters = new SpyFilterValueObject([]);
        $sorts = new SpySortValueObject([]);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($this->spies);

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertCount(3, $result);
        $this->assertEquals('John', $result[0]->name()->value());
        $this->assertEquals('Jane', $result[1]->name()->value());
        $this->assertEquals('James', $result[2]->name()->value());
    }

    public function testHandleFilteringWithNameAndSurname()
    {
        $filters = new SpyFilterValueObject(['name' => 'John', 'surname' => 'Doe']);
        $sorts = new SpySortValueObject([]);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $filteredSpies = $this->spies->filter(function ($spy) {
            return $spy->name()->value() === 'John' && $spy->surname()->value() === 'Doe';
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($filteredSpies);

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertCount(1, $result);
        $this->assertEquals('John', $result[0]->name()->value());
    }

    public function testHandleFilterWithExactAgeFilter()
    {
        $filters = new SpyFilterValueObject(['exact_age' => 32]);
        $sorts = new SpySortValueObject([]);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $filteredSpies = $this->spies->filter(function ($spy) {
            return $spy->name()->value() === 'Jane';
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($filteredSpies);

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertCount(1, $result);
        $this->assertEquals('Jane', $result[0]->name()->value());
    }

    public function testHandleFilterWithAgeRangeFilter()
    {
        $filters = new SpyFilterValueObject(['age_min' => 30, 'age_max' => 40]);
        $sorts = new SpySortValueObject([]);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $filteredSpies = $this->spies->filter(function ($spy) {
            return $spy->name()->value() === 'John';
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($filteredSpies);

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertCount(1, $result);
        $this->assertEquals('John', $result[0]->name()->value());
    }

    public function testHandleWithSortingByFullName()
    {
        $filters = new SpyFilterValueObject([]);
        $sorts = new SpySortValueObject(['full_name' => 'asc']);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $sortedSpies = $this->spies->sortBy(function ($spy) {
            return $spy->name()->value();
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($sortedSpies->values());

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertEquals('James', $result[0]->name()->value());
        $this->assertEquals('Jane', $result[1]->name()->value());
        $this->assertEquals('John', $result[2]->name()->value());
    }

    public function testHandleWithSortingByDateOfBirth()
    {
        $filters = new SpyFilterValueObject([]);
        $sorts = new SpySortValueObject(['date_of_birth' => 'desc']);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $sortedSpies = $this->spies->sortByDesc(function ($spy) {
            return $spy->dateOfBirth()->value();
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($sortedSpies->values());

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertEquals('Jane', $result[0]->name()->value());
        $this->assertEquals('John', $result[1]->name()->value());
        $this->assertEquals('James', $result[2]->name()->value());
    }

    public function testHandleWithSortingByDateOfDeath()
    {
        $filters = new SpyFilterValueObject([]);
        $sorts = new SpySortValueObject(['date_of_death' => 'desc']);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $sortedSpies = $this->spies->sortByDesc(function ($spy) {
            return $spy->dateOfDeath() ? $spy->dateOfDeath()->value() : null;
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($sortedSpies->values());

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertEquals('Jane', $result[0]->name()->value());
        $this->assertEquals('John', $result[1]->name()->value());
        $this->assertEquals('James', $result[2]->name()->value());
    }

    public function testHandleWithMultipleSorts()
    {
        $filters = new SpyFilterValueObject([]);
        $sorts = new SpySortValueObject(['full_name' => 'asc', 'date_of_birth' => 'desc']);
        $queryParams = new QueryParametersDTO($filters, $sorts);

        $sortedSpies = $this->spies->sortBy(function ($spy) {
            return [$spy->name()->value(), $spy->dateOfBirth()->value()];
        })->values();

        $this->spyService->shouldReceive('getFilteredSpies')
            ->once()
            ->with($queryParams)
            ->andReturn($sortedSpies->values());

        $listSpiesQuery = new ListSpiesQuery($queryParams);
        $handler = new ListSpiesHandler($this->spyService);

        $result = $handler->handle($listSpiesQuery);

        $this->assertEquals('James', $result[0]->name()->value());
        $this->assertEquals('Jane', $result[1]->name()->value());
        $this->assertEquals('John', $result[2]->name()->value());
    }
}
