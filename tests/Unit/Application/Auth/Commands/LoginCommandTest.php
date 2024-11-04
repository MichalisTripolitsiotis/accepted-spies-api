<?php

namespace Tests\Unit\Application\Auth\Commands;

use App\Application\Auth\Commands\LoginCommand;
use App\Application\Auth\DTOs\LoginData;
use Tests\TestCase;

class LoginCommandTest extends TestCase
{
    public function testLoginCommandCanBeConstructed(): void
    {
        $loginData = LoginData::make(['email' => 'test@example.com', 'password' => 'password123']);

        $command = new LoginCommand($loginData);

        $this->assertInstanceOf(LoginCommand::class, $command);
        $this->assertSame($loginData, $command->loginData);
    }

    public function testLoginCommandStoresLoginDataCorrectly(): void
    {
        $loginData = LoginData::make(['email' => 'user@example.com', 'password' => 'secure_password']);

        $command = new LoginCommand($loginData);

        $this->assertEquals('user@example.com', $command->loginData->email->value());
        $this->assertEquals('secure_password', $command->loginData->password->value());
    }
}
