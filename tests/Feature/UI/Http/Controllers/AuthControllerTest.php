<?php

namespace Tests\Feature\UI\Http\Controllers;

use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /**
     * Set up method
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserModel::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function testLoginSuccessfullyReturnsToken()
    {
        $response = $this->postJson(self::API_BASE.'auth/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertNotEquals(null, $response->json('auth_token'));
    }

    public function testLoginFailsWithInvalidCredentials()
    {
        $response = $this->postJson(self::API_BASE.'auth/login', [
            'email' => $this->user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'The provided credentials are incorrect.']);
    }

    public function testLogoutSuccessfullyRevokesToken()
    {
        $authToken = $this->user->createToken('authToken')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer '.$authToken);

        $logoutResponse = $this->postJson(self::API_BASE.'auth/logout');

        $logoutResponse->assertStatus(200);
        $logoutResponse->assertJson(['message' => 'Logged out successfully']);

        $this->assertEmpty($this->user->tokens()->get());
    }
}
