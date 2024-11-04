<?php

namespace Tests\Feature\Application\Spy;

use App\Infrastructure\Laravel\Models\SpyModel;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListRandomSpiesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserModel::factory()->create();

        SpyModel::factory()->create([
            'name' => 'John',
            'surname' => 'Doe',
            'agency' => 'CIA',
            'country_of_operation' => 'USA',
            'date_of_birth' => '1985-01-01',
        ]);

        SpyModel::factory()->create([
            'name' => 'Jane',
            'surname' => 'Smith',
            'agency' => 'MI6',
            'country_of_operation' => 'England',
            'date_of_birth' => '1990-05-15',
        ]);

        SpyModel::factory()->create([
            'name' => 'James',
            'surname' => 'Bond',
            'agency' => 'MI6',
            'country_of_operation' => 'England',
            'date_of_birth' => '1953-03-18',
        ]);
    }

    public function testListRandomSpiesReturnsTwoRandomSpies()
    {
        $response = $this->actingAs($this->user)->getJson(self::API_BASE.'spy/random');

        $response->assertStatus(200);

        $response->assertJsonCount(3);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'surname',
                'agency',
                'country_of_operation',
                'date_of_birth',
                'date_of_death',
            ],
        ]);

        $response->assertJsonFragment(['name' => 'John']);
        $response->assertJsonFragment(['name' => 'Jane']);
        $response->assertJsonFragment(['name' => 'James']);
    }
}
