<?php

namespace Tests\Unit\Domain\Auth\Repositories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\Repositories\AuthenticationServiceInterface;
use App\Domain\Auth\ValueObjects\UserPassword;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class AuthenticationServiceInterfaceTest extends TestCase
{
    protected $authService;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = Mockery::mock(AuthenticationServiceInterface::class);
        $this->user = UserFactory::create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function testAttemptReturnsUserOnValidCredentials()
    {
        $password = new UserPassword('password');

        $this->authService->shouldReceive('attempt')
            ->once()
            ->with($this->user->email(), $password)
            ->andReturn($this->user);

        $authenticatedUser = $this->authService->attempt($this->user->email(), $password);

        $this->assertInstanceOf(User::class, $authenticatedUser);
    }

    public function testAttemptReturnsNullOnInvalidCredentials()
    {
        $password = new UserPassword('wrong_password');

        $this->authService->shouldReceive('attempt')
            ->once()
            ->with($this->user->email(), $password)
            ->andReturnNull();

        $user = $this->authService->attempt($this->user->email(), $password);

        $this->assertNull($user);
    }

    public function testGenerateTokenReturnsTokenString()
    {
        $this->authService->shouldReceive('generateToken')
            ->once()
            ->with($this->user)
            ->andReturn('auth_token');

        $generatedToken = $this->authService->generateToken($this->user);

        $this->assertIsString($generatedToken);
        $this->assertEquals('auth_token', $generatedToken);
    }

    public function testRevokeTokensCallsMethodOnUser()
    {
        $this->authService->shouldReceive('revokeTokens')
            ->once()
            ->with($this->user)
            ->andReturnTrue();

        $result = $this->authService->revokeTokens($this->user);

        $this->assertTrue($result);
        $this->authService->shouldHaveReceived('revokeTokens')->with($this->user);
    }
}
