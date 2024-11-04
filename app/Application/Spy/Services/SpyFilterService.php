<?php

declare(strict_types=1);

namespace App\Application\Spy\Services;

use App\Domain\Common\DTOs\QueryParametersDTO;
use App\Domain\Spy\Repositories\SpyRepositoryInterface;
use Carbon\Carbon;

class SpyFilterService
{
    public function __construct(private SpyRepositoryInterface $spyRepository) {}

    public function getFilteredSpies(QueryParametersDTO $options): mixed
    {
        $query = $this->spyRepository->all();

        $this->applyFilters($query, $options->filters->toArray());
        $this->applySorts($query, $options->sorts->toArray());

        return $query->paginate($options->perPage, ['*'], 'page', $options->page);
    }

    private function applyFilters($query, array $filters): void
    {
        if (isset($filters['exact_age'])) {
            [$startOfBirthYear, $endOfBirthYear] = $this->getExactAgeDateRange((int) $filters['exact_age']);
            $this->applyAgeExactFilter($query, $startOfBirthYear, $endOfBirthYear, (int) $filters['exact_age']);
        } elseif (isset($filters['age_min'], $filters['age_max'])) {
            [$minDateOfBirth, $maxDateOfBirth] = $this->getAgeRangeDateRange((int) $filters['age_min'], (int) $filters['age_max']);
            $this->applyAgeRangeFilter($query, $minDateOfBirth, $maxDateOfBirth, $filters);
        }

        foreach ($filters as $field => $value) {
            if (in_array($field, ['name', 'surname'])) {
                $query->where($field, 'like', "%$value%");
            }
        }
    }

    private function applySorts($query, array $sorts): void
    {
        foreach ($sorts as $field => $direction) {
            if ($field === 'full_name') {
                $query->orderByRaw("CONCAT(name, ' ', surname) $direction");
            } else {
                $query->orderBy($field, $direction);
            }
        }
    }

    private function getExactAgeDateRange(int $age): array
    {
        $startOfBirthYear = Carbon::now()->subYears($age)->startOfYear();
        $endOfBirthYear = Carbon::now()->subYears($age)->endOfYear();

        return [$startOfBirthYear, $endOfBirthYear];
    }

    private function getAgeRangeDateRange(int $ageMin, int $ageMax): array
    {
        $maxDateOfBirth = Carbon::now()->subYears($ageMin)->endOfYear();
        $minDateOfBirth = Carbon::now()->subYears($ageMax)->startOfYear();

        return [$minDateOfBirth, $maxDateOfBirth];
    }

    private function applyAgeExactFilter($query, $startOfBirthYear, $endOfBirthYear, int $age): void
    {
        $query->where(function ($query) use ($startOfBirthYear, $endOfBirthYear, $age) {
            $query->whereNull('date_of_death')
                ->whereBetween('date_of_birth', [$startOfBirthYear, $endOfBirthYear])
                ->orWhere(function ($query) use ($age) {
                    $query->whereNotNull('date_of_death')
                        ->whereBetween('date_of_birth', [now()->subYears($age + 1), now()->subYears($age)]);
                });
        });
    }

    private function applyAgeRangeFilter($query, $minDateOfBirth, $maxDateOfBirth, array $filters): void
    {
        $query->where(function ($query) use ($minDateOfBirth, $maxDateOfBirth, $filters) {
            $query->whereNull('date_of_death')
                ->whereBetween('date_of_birth', [$minDateOfBirth, $maxDateOfBirth]);

            $query->orWhere(function ($query) use ($minDateOfBirth, $maxDateOfBirth, $filters) {
                $query->whereNotNull('date_of_death')
                    ->whereBetween('date_of_birth', [$minDateOfBirth, $maxDateOfBirth])
                    ->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, date_of_death) BETWEEN ? AND ?', [
                        $filters['age_min'],
                        $filters['age_max'],
                    ]);
            });
        });
    }
}
