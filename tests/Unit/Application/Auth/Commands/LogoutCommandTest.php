<?php

namespace Tests\Unit\Application\Auth\Commands;

use App\Application\Auth\Commands\LogoutCommand;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class LogoutCommandTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function testLogoutCommandCanBeConstructed(): void
    {
        $command = new LogoutCommand($this->user);

        $this->assertInstanceOf(LogoutCommand::class, $command);
        $this->assertSame($this->user, $command->user);
    }

    public function testLogoutCommandStoresUserCorrectly(): void
    {
        $command = new LogoutCommand($this->user);
        $this->assertSame($this->user, $command->user);
    }
}
