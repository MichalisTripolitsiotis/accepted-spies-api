<?php

declare(strict_types=1);

namespace App\Application\Spy\Queries;

use App\Domain\Common\Bus\Query;

class ListRandomSpiesQuery extends Query
{
    public function __construct(private int $limit = 5) {}

    public function getLimit(): int
    {
        return $this->limit;
    }
}
