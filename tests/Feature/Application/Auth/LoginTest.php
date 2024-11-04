<?php

namespace Tests\Feature\Application\Auth;

use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserModel::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
        ]);
    }

    public function testLoginSuccessfully(): void
    {
        $payload = [
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(self::API_BASE.'auth/login', $payload);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'auth_token',
        ]);

        $this->assertNotEmpty($response->json('auth_token'));

        $this->assertTrue(Auth::check());
    }

    public function testLoginFailsWithInvalidCredentials(): void
    {
        $payload = [
            'email' => 'john.doe@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson(self::API_BASE.'auth/login', $payload);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'The provided credentials are incorrect.',
        ]);

        $this->assertFalse(Auth::check());
    }

    public function testLoginFailsWithValidationErrors(): void
    {
        $payload = [
            'email' => '',
            'password' => '',
        ];

        $response = $this->postJson(self::API_BASE.'auth/login', $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
