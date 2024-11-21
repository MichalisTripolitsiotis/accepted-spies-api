<?php

declare(strict_types=1);

namespace App\Application\Agency\Queries;

use App\Domain\Common\Bus\Query;
use App\Domain\Common\DTOs\QueryParametersDTO;

class ListAgenciesQuery extends Query
{
    public function __construct(public QueryParametersDTO $options) {}

    public function getParameters(): QueryParametersDTO
    {
        return $this->options;
    }
}
