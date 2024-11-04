<?php

namespace Tests\Feature\Application\Auth;

use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserModel::factory()->create();
    }

    public function testLogoutSuccessfully(): void
    {
        $response = $this->actingAs($this->user)->postJson(self::API_BASE.'auth/logout');

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Logged out successfully',
        ]);
    }

    public function testLogoutWhenNotAuthenticated(): void
    {
        $response = $this->postJson(self::API_BASE.'auth/logout');

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
