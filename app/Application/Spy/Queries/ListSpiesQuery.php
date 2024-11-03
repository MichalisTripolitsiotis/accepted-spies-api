<?php

declare(strict_types=1);

namespace App\Application\Spy\Queries;

use App\Domain\Common\Bus\Query;
use App\Domain\Common\DTOs\QueryParametersDTO;

class ListSpiesQuery extends Query
{
    public function __construct(public QueryParametersDTO $options) {}

    public function getParameters(): QueryParametersDTO
    {
        return $this->options;
    }
}
