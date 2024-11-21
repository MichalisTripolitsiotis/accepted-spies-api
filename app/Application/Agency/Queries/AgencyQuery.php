<?php

namespace App\Application\Agency\Queries;

use App\Domain\Common\Bus\Query;

class AgencyQuery extends Query
{
    public function __construct(public string|int $id) {}

    public function getId(): int
    {
        return (int) $this->id;
    }
}
