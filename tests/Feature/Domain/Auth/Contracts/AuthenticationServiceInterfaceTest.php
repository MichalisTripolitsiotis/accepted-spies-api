<?php

namespace Tests\Feature\Domain\Auth\Contracts;

use App\Domain\Auth\Contracts\AuthenticationServiceInterface;
use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Auth\ValueObjects\UserPassword;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class AuthenticationServiceInterfaceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthenticationServiceInterface $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = $this->app->make(AuthenticationServiceInterface::class);
    }

    public function testAttemptWithValidCredentialsReturnsUser(): void
    {
        $userModel = UserModel::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $email = new UserEmail('john.doe@example.com');
        $password = new UserPassword('password');

        $user = $this->authService->attempt($email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userModel->email, $user->email()->value());
    }

    public function testAttemptWithInvalidCredentialsReturnsNull(): void
    {
        UserModel::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $email = new UserEmail('john.doe@example.com');
        $password = new UserPassword('wrong_password');
        $user = $this->authService->attempt($email, $password);

        $this->assertNull($user);
    }

    public function testGenerateTokenForAuthenticatedUser(): void
    {
        $userModel = UserModel::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $user = UserFactory::create([
            'name' => $userModel->name,
            'email' => $userModel->email,
            'email_verified_at' => $userModel->email_verified_at,
            'password' => $userModel->password,
            'remember_token' => $userModel->remember_token,
        ]);

        $token = $this->authService->generateToken($user);

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }

    public function testRevokeTokensForUser(): void
    {
        $userModel = UserModel::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $user = UserFactory::create([
            'name' => $userModel->name,
            'email' => $userModel->email,
            'email_verified_at' => $userModel->email_verified_at,
            'password' => $userModel->password,
            'remember_token' => $userModel->remember_token,
        ]);

        $result = $this->authService->revokeTokens($user);

        $this->assertTrue($result);
    }
}
