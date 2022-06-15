<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Common\Repository\Filter;

use CongregationManager\Domain\Territory\Model\TerritoryInterface;

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
