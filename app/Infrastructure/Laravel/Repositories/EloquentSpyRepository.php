<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Repositories;

use App\Domain\Common\DTOs\Pagination\PaginatedResult;
use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Domain\Spy\ValueObjects\SpyId;
use App\Infrastructure\Laravel\Models\SpyModel;

class EloquentSpyRepository implements SpyRepositoryInterface
{
    public function create(Spy $spy): void
    {
        try {
            $spyModel = SpyModel::create([
                'name' => $spy->name()->value(),
                'surname' => $spy->surname()->value(),
                'agency' => $spy->agency()->value,
                'country_of_operation' => $spy->countryOfOperation()->value(),
                'date_of_birth' => $spy->dateOfBirth()->value(),
                'date_of_death' => $spy->dateOfDeath()?->value(),
            ]);

            $spy->assignId(new SpyId($spyModel->id));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function randomEntries(int $count): array
    {
        return SpyModel::inRandomOrder()->limit($count)->get()->toArray();
    }
}
