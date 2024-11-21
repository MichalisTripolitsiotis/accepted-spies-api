<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Repositories;

use App\Domain\Agency\Entities\Agency;
use App\Domain\Agency\Repositories\AgencyRepositoryInterface;
use App\Domain\Agency\ValueObjects\AgencyId;
use App\Domain\Agency\ValueObjects\AgencyName;
use App\Infrastructure\Laravel\Models\AgencyModel;

class EloquentAgencyRepository implements AgencyRepositoryInterface
{
    public function findById(AgencyId $agencyId): ?Agency
    {
        $agencyModel = AgencyModel::find($agencyId->value());

        if (! $agencyModel) {
            return null;
        }

        return new Agency(
            new AgencyName($agencyModel->name),
            new AgencyId($agencyModel->id),
        );
    }

    public function create(Agency $agency): ?Agency
    {
        try {
            $agencyModel = AgencyModel::create([
                'name' => $agency->name()->value(),
            ]);

            $agency->assignId(new AgencyId($agencyModel->id));

            return $agency;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function all(): mixed
    {
        return AgencyModel::query();
    }
}
