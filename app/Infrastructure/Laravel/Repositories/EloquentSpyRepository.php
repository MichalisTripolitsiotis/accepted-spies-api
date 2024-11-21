<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Repositories;

use App\Domain\Agency\Entities\Agency;
use App\Domain\Agency\ValueObjects\AgencyId;
use App\Domain\Agency\ValueObjects\AgencyName;
use App\Domain\Spy\Entities\Spy;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use App\Domain\Spy\ValueObjects\SpyCountryOfOperation;
use App\Domain\Spy\ValueObjects\SpyDateOfBirth;
use App\Domain\Spy\ValueObjects\SpyDateOfDeath;
use App\Domain\Spy\ValueObjects\SpyId;
use App\Domain\Spy\ValueObjects\SpyName;
use App\Domain\Spy\ValueObjects\SpySurname;
use App\Infrastructure\Laravel\Models\SpyModel;

class EloquentSpyRepository implements SpyRepositoryInterface
{
    public function create(Spy $spy): ?Spy
    {
        try {
            $spyModel = SpyModel::create([
                'name' => $spy->name()->value(),
                'surname' => $spy->surname()->value(),
                'agency_id' => $spy->agency()->id()->value(),
                'country_of_operation' => $spy->countryOfOperation()->value(),
                'date_of_birth' => $spy->dateOfBirth()->value(),
                'date_of_death' => $spy->dateOfDeath()?->value(),
            ]);

            $spy->assignId(new SpyId($spyModel->id));

            return $spy;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function randomEntries(int $limit): array
    {
        $records = SpyModel::with('agency')->inRandomOrder()->limit($limit)->get();

        return $records->map(function ($record) {
            return new Spy(
                new SpyName($record->name),
                new SpySurname($record->surname),
                new Agency(new AgencyName($record->agency->name), new AgencyId($record->agency->id)),
                new SpyCountryOfOperation($record->country_of_operation),
                new SpyDateOfBirth($record->date_of_birth->toDateString()),
                $record->date_of_death ? new SpyDateOfDeath($record->date_of_death->toDateString()) : null,
                new SpyId($record->id),
            );
        })->all();
    }

    public function all(): mixed
    {
        return SpyModel::query();
    }
}
