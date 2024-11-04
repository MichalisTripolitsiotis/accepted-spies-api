<?php

namespace Tests\Feature\Application\Spy;

use App\Domain\Spy\Events\SpyCreated;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateSpyTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserModel::factory()->create();
    }

    public function testCreateSpySuccessfully(): void
    {
        Event::fake();

        $payload = [
            'name' => 'James',
            'surname' => 'Bond',
            'agency' => 'MI6',
            'country' => 'UK',
            'date_of_birth' => '1953-03-18',
            'date_of_death' => null,
        ];

        $response = $this->actingAs($this->user)->postJson(self::API_BASE.'spy/store', $payload);

        $response->assertStatus(201);

        Event::assertDispatched(SpyCreated::class);

        $response->assertJsonStructure([
            'id',
            'name',
            'surname',
            'agency',
            'country_of_operation',
            'date_of_birth',
            'date_of_death',
        ]);

        $response->assertJsonFragment([
            'name' => 'James',
            'surname' => 'Bond',
            'agency' => 'MI6',
        ]);

        $this->assertDatabaseHas('spies', [
            'name' => 'James',
            'surname' => 'Bond',
            'agency' => 'MI6',
            'country_of_operation' => 'UK',
            'date_of_birth' => '1953-03-18',
            'date_of_death' => null,
        ]);
    }

    public function testCreateSpyValidationError(): void
    {
        $payload = [
            'name' => '',
            'surname' => '',
            'agency' => '',
            'country' => '',
            'date_of_birth' => 'invalid-date',
        ];

        $response = $this->actingAs($this->user)->postJson(self::API_BASE.'spy/store', $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'surname',
            'agency',
            'country',
            'date_of_birth',
        ]);

        $response->assertJsonValidationErrors(['name', 'surname', 'agency', 'country', 'date_of_birth']);
    }
}
