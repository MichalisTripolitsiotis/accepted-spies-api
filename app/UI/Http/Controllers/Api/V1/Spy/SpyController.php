<?php

declare(strict_types=1);

namespace App\UI\Http\Controllers\Api\V1\Spy;

use App\Infrastructure\Laravel\Controller;
use App\Application\Spy\Actions\CreateSpyAction;
use App\Application\Spy\DTOs\SpyResponse;
use App\UI\Http\Requests\Spy\CreateSpyRequest;
use Illuminate\Http\JsonResponse;

class SpyController extends Controller
{
    public function __construct(private CreateSpyAction $createSpyAction) {}

    public function store(CreateSpyRequest $request): JsonResponse
    {
        $spy = $this->createSpyAction->execute($request->payload());

        $spyResponse = new SpyResponse($spy);

        return response()->json($spyResponse->toArray(), 201);
    }
}
