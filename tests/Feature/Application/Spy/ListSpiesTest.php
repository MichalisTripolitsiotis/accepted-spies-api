<?php

namespace Tests\Feature\Application\Spy;

use App\Infrastructure\Laravel\Models\AgencyModel;
use App\Infrastructure\Laravel\Models\SpyModel;
use App\Infrastructure\Laravel\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListSpiesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2024-11-04');

        $this->user = UserModel::factory()->create();

        $agencyId = AgencyModel::factory()->create()->id;

        SpyModel::create([
            'name' => 'John',
            'surname' => 'Doe',
            'agency_id' => $agencyId,
            'country_of_operation' => 'USA',
            'date_of_birth' => '1985-01-01',
            'date_of_death' => null,
        ]);

        SpyModel::create([
            'name' => 'Jane',
            'surname' => 'Smith',
            'agency_id' => $agencyId,
            'country_of_operation' => 'England',
            'date_of_birth' => '1990-05-15',
            'date_of_death' => '2022-05-15',
        ]);

        SpyModel::create([
            'name' => 'James',
            'surname' => 'Bond',
            'agency_id' => $agencyId,
            'country_of_operation' => 'England',
            'date_of_birth' => '1953-03-18',
            'date_of_death' => null,
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function testListSpiesWithoutFiltersOrSorting()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/all');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment(['name' => 'John'])
            ->assertJsonFragment(['name' => 'Jane'])
            ->assertJsonFragment(['name' => 'James']);
    }

    public function testListSpiesFilteringWithNameAndSurname()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/all?filters[name]=John&filters[surname]=Doe');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'John']);
    }

    public function testListSpiesWithExactAgeFilter()
    {
        $exactAge = 34;

        $response = $this->actingAs($this->user)->getJson(self::API_BASE."spy/all?filters[exact_age]={$exactAge}");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'Jane']);
    }

    public function testListSpiesWithAgeRangeFilter()
    {
        $ageMin = 30;
        $ageMax = 40;

        $response = $this->actingAs($this->user)->getJson(self::API_BASE."spy/all?filters[age_min]={$ageMin}&filters[age_max]={$ageMax}");

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['name' => 'John'])
            ->assertJsonFragment(['name' => 'Jane']);
    }

    public function testListSpiesWithSortingByFullName()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/all?sorting[full_name]=asc');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'James'])
            ->assertJsonFragment(['name' => 'Jane'])
            ->assertJsonFragment(['name' => 'John']);
    }

    public function testListSpiesWithSortingByDateOfBirth()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/all?sorting[date_of_birth]=desc');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Jane'])
            ->assertJsonFragment(['name' => 'John'])
            ->assertJsonFragment(['name' => 'James']);
    }

    public function testListSpiesWithSortingByDateOfDeath()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/all?sorting[date_of_death]=desc');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Jane']);
    }

    public function testListSpiesWithMultipleSorts()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/all?sorting[full_name]=asc&sorting[date_of_birth]=desc');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'James'])
            ->assertJsonFragment(['name' => 'Jane'])
            ->assertJsonFragment(['name' => 'John']);
    }
}
