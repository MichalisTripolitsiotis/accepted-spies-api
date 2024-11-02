<?php

declare(strict_types=1);

namespace App\Application\Spy\DTOs;

use App\Domain\Spy\Entities\Spy;

final readonly class SpyCollectionResponse
{
    private array $spies;

    public function __construct(array $spies)
    {
        $this->spies = $spies;
    }

    public function toArray(): array
    {
        return array_map(fn (Spy $spy) => (new SpyResponse($spy))->toArray(), $this->spies);
    }
}
