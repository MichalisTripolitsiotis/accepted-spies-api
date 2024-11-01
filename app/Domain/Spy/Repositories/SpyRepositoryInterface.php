<?php

declare(strict_types=1);

namespace App\Domain\Spy\Repositories;

use App\Domain\Spy\Entities\Spy;

interface SpyRepositoryInterface
{
    public function create(Spy $spy): void;

    public function randomEntries(int $count): array;
}
