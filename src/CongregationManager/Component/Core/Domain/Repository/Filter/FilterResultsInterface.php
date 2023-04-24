<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Repository\Filter;

use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;

interface FilterResultsInterface
{
    public function getTotalCount(): int;

    /**
     * @return TerritoryInterface[]
     */
    public function getResults(
        ?int $limit = null,
        ?int $offset = null,
        ?string $sort = null,
        string $direction = 'ASC'
    ): array;
}
