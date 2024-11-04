<?php

namespace Tests\Unit\Application\Spy\Queries;

use App\Application\Spy\Queries\ListRandomSpiesQuery;
use Tests\TestCase;

class ListRandomSpiesQueryTest extends TestCase
{
    public function testQueryStoresAndReturnsCorrectLimit(): void
    {
        $limit = 10;
        $query = new ListRandomSpiesQuery($limit);
        $this->assertEquals($limit, $query->getLimit());
    }

    public function testQueryDefaultsToFive(): void
    {
        $query = new ListRandomSpiesQuery;
        $this->assertEquals(5, $query->getLimit());
    }
}
