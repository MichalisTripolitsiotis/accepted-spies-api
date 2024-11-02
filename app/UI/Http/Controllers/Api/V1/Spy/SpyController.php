<?php

declare(strict_types=1);

namespace App\UI\Http\Controllers\Api\V1\Spy;

use App\Application\Spy\Commands\CreateSpyCommand;
use App\Application\Spy\DTOs\SpyCollectionResponse;
use App\Application\Spy\DTOs\SpyResponse;
use App\Application\Spy\Queries\ListRandomSpiesQuery;
use App\Domain\Common\Bus\CommandBus;
use App\Domain\Common\Bus\QueryBus;
use App\Infrastructure\Laravel\Controller;
use App\UI\Http\Requests\Spy\CreateSpyRequest;
use Illuminate\Http\JsonResponse;

class SpyController extends Controller
{
    public function __construct(private CommandBus $commandBus, private QueryBus $queryBus) {}

    public function store(CreateSpyRequest $request): JsonResponse
    {
        $command = new CreateSpyCommand($request->payload());
        $spy = $this->commandBus->dispatch($command);

        return response()->json((new SpyResponse($spy))->toArray(), 201);
    }

    public function random(): JsonResponse
    {
        $query = new ListRandomSpiesQuery(5);
        $spies = $this->queryBus->ask($query);

        $response = new SpyCollectionResponse($spies);

        return response()->json($response->toArray());
    }
}
