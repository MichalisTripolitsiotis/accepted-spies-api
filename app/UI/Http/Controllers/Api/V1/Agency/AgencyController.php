<?php

declare(strict_types=1);

namespace App\UI\Http\Controllers\Api\V1\Agency;

use App\Application\Agency\Commands\CreateAgencyCommand;
use App\Application\Agency\DTOs\AgencyResponse;
use App\Application\Agency\Queries\AgencyQuery;
use App\Application\Agency\Queries\ListAgenciesQuery;
use App\Domain\Common\Bus\CommandBus;
use App\Domain\Common\Bus\QueryBus;
use App\Infrastructure\Laravel\Controller;
use App\UI\Http\Requests\Agency\AllAgenciesRequest;
use App\UI\Http\Requests\Agency\CreateAgencyRequest;
use Illuminate\Http\JsonResponse;

class AgencyController extends Controller
{
    public function __construct(private CommandBus $commandBus, private QueryBus $queryBus) {}

    public function store(CreateAgencyRequest $request): JsonResponse
    {
        $command = new CreateAgencyCommand($request->payload());
        $agency = $this->commandBus->dispatch($command);

        return response()->json((new AgencyResponse($agency))->toArray(), 201);
    }

    public function all(AllAgenciesRequest $request): JsonResponse
    {
        try {
            $query = new ListAgenciesQuery($request->payload());
            $agencies = $this->queryBus->ask($query);

            return response()->json($agencies);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $query = new AgencyQuery($id);
            $agency = $this->queryBus->ask($query);

            return response()->json((new AgencyResponse($agency))->toArray(), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
