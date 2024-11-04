<?php

namespace Tests\Unit\Application\Spy\Queries;

use App\Application\Spy\Queries\ListSpiesQuery;
use App\Domain\Common\DTOs\QueryParametersDTO;
use App\Domain\Spy\ValueObjects\SpyFilterValueObject;
use App\Domain\Spy\ValueObjects\SpySortValueObject;
use PHPUnit\Framework\TestCase;

class ListSpiesQueryTest extends TestCase
{
    public function testConstructorAssignsOptionsCorrectly(): void
    {
        $filters = new SpyFilterValueObject(['name' => 'James']);
        $sorts = new SpySortValueObject(['full_name' => 'asc']);
        $queryParameters = new QueryParametersDTO($filters, $sorts, 1, 10);

        $listSpiesQuery = new ListSpiesQuery($queryParameters);

        $this->assertSame($queryParameters, $listSpiesQuery->getParameters());
    }

    public function testGetParametersReturnsCorrectValue(): void
    {
        $filters = new SpyFilterValueObject(['age_min' => 30, 'age_max' => 40]);
        $sorts = new SpySortValueObject(['date_of_birth' => 'desc']);
        $queryParameters = new QueryParametersDTO($filters, $sorts, 1, 20);

        $listSpiesQuery = new ListSpiesQuery($queryParameters);

        $result = $listSpiesQuery->getParameters();

        $this->assertInstanceOf(QueryParametersDTO::class, $result);
        $this->assertEquals($filters, $result->filters);
        $this->assertEquals($sorts, $result->sorts);
        $this->assertEquals(1, $result->page);
        $this->assertEquals(20, $result->perPage);
    }
}
