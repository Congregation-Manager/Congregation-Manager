<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Common\Repository\Filter;

interface FilterResultsInterface
{
    public function getTotalCount(): int;

    public function getResults(?int $limit = null, ?int $offset = null, ?string $sort = null, string $direction = 'ASC'): array;
}
