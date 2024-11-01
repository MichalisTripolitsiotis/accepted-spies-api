<?php

declare(strict_types=1);

namespace App\UI\Http\Controllers\Api\V1\Auth;

use App\Application\Auth\Commands\LoginCommand;
use App\Application\Auth\Commands\LogoutCommand;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\ValueObjects\UserEmail;
use App\Domain\Common\Contracts\BusInterface;
use App\Infrastructure\Laravel\Controller;
use App\UI\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private BusInterface $bus,
        private UserRepositoryInterface $userRepository
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $command = new LoginCommand($request->payload());

        $token = $this->bus->dispatch($command);

        return response()->json(['auth_token' => $token]);
    }

    public function logout(): JsonResponse
    {
        $userModel = Auth::user();

        if (! $userModel) {
            return response()->json(['message' => 'No authenticated user found'], 401);
        }

        $email = new UserEmail($userModel->email);
        $user = $this->userRepository->findByEmail($email);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $command = new LogoutCommand($user);
        $this->bus->dispatch($command);

        return response()->json(['message' => 'Logged out successfully']);
    }
}
