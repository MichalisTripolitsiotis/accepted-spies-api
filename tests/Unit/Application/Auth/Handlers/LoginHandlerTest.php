<?php

namespace Tests\Unit\Application\Auth\Handlers;

use App\Application\Auth\Commands\LoginCommand;
use App\Application\Auth\DTOs\LoginData;
use App\Application\Auth\Handlers\LoginHandler;
use App\Domain\Auth\Contracts\AuthenticationServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Mockery;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class LoginHandlerTest extends TestCase
{
    protected $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = Mockery::mock(AuthenticationServiceInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testHandleSuccessfullyAuthenticatesAndGeneratesToken(): void
    {
        $user = UserFactory::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $loginData = LoginData::make(['email' => 'john.doe@example.com', 'password' => 'password']);
        $loginCommand = new LoginCommand($loginData);

        $this->authService->shouldReceive('attempt')
            ->once()
            ->withArgs(function ($email, $password) {
                return $email->value() === 'john.doe@example.com' && $password->value() === 'password';
            })
            ->andReturn($user);

        $this->authService->shouldReceive('generateToken')
            ->once()
            ->with($user)
            ->andReturn('auth_token');

        $handler = new LoginHandler($this->authService);

        $token = $handler->handle($loginCommand);

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
        $this->assertEquals('auth_token', $token);
    }

    public function testHandleThrowsAuthenticationExceptionOnInvalidCredentials(): void
    {
        $loginData = LoginData::make(['email' => 'john.doe@example.com', 'password' => 'wrong_password']);
        $loginCommand = new LoginCommand($loginData);

        $this->authService->shouldReceive('attempt')
            ->once()
            ->withArgs(function ($email, $password) {
                return $email->value() === 'john.doe@example.com' && $password->value() === 'wrong_password';
            })
            ->andReturn(null);

        $handler = new LoginHandler($this->authService);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('The provided credentials are incorrect.');

        $handler->handle($loginCommand);
    }
}
