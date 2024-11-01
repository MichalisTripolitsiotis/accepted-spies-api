<?php

declare(strict_types=1);

namespace App\Application\Spy\Queries;

class ListRandomSpiesQuery
{
    public function __construct(private int $limit = 5) {}

    public function getLimit(): int
    {
        return $this->limit;
    }
}
