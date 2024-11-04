<?php

namespace Tests\Unit\Domain\Auth\Repositories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\ValueObjects\UserEmail;
use Mockery;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class UserRepositoryInterfaceTest extends TestCase
{
    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testFindByEmailReturnsUser(): void
    {
        $user = UserFactory::create(['email' => 'john.doe@example.com']);

        $this->userRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::on(function ($arg) use ($user) {
                return $arg->value() === $user->email()->value();
            }))
            ->andReturn($user);

        $result = $this->userRepository->findByEmail($user->email());

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('john.doe@example.com', $result->email()->value());
    }

    public function testFindByEmailReturnsNullWhenUserNotFound(): void
    {
        $email = new UserEmail('nonexistent@example.com');

        $this->userRepository->shouldReceive('findByEmail')
            ->once()
            ->with(Mockery::on(function ($arg) use ($email) {
                return $arg->value() === $email->value();
            }))
            ->andReturn(null);

        $result = $this->userRepository->findByEmail($email);

        $this->assertNull($result);
    }
}
