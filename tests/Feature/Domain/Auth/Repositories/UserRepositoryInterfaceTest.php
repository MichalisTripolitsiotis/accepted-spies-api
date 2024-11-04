<?php

namespace Tests\Feature\Domain\Auth\Repositories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryInterfaceTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
    }

    public function testFindByEmailReturnsUser(): void
    {
        $userModel = UserModel::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $email = new UserEmail($userModel->email);
        $user = $this->userRepository->findByEmail($email);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name()->value());
        $this->assertEquals('john.doe@example.com', $user->email()->value());
    }

    public function testFindByEmailReturnsNullForNonExistingUser(): void
    {
        $email = new UserEmail('nonexistent@example.com');
        $user = $this->userRepository->findByEmail($email);

        $this->assertNull($user);
    }
}
