<?php

declare(strict_types=1);

namespace App\Domain\Common\DTOs;

use App\Domain\Spy\ValueObjects\SpyFilterValueObject;
use App\Domain\Spy\ValueObjects\SpySortValueObject;

final class QueryParametersDTO
{
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_PER_PAGE = 10;

    public function __construct(
        public SpyFilterValueObject $filters,
        public SpySortValueObject $sorts,
        public int $page,
        public int $perPage,
    ) {}

    public static function make(array $data): QueryParametersDTO
    {
        return new QueryParametersDTO(
            filters: new SpyFilterValueObject($data['filters'] ?? []),
            sorts: new SpySortValueObject($data['sorting'] ?? []),
            page: isset($data['page']) ? (int) $data['page'] : self::DEFAULT_PAGE,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : self::DEFAULT_PER_PAGE
        );
    }
}
