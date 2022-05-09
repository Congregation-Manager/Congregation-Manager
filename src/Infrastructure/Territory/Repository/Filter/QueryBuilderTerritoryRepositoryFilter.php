<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository\Filter;

use CongregationManager\Domain\Territory\Model\AreaInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryRepositoryFilterInterface;

final class QueryBuilderTerritoryRepositoryFilter implements TerritoryRepositoryFilterInterface
{
    private ?AreaInterface $inArea = null;

    public function byArea(?AreaInterface $area): void
    {
        $this->inArea = $area;
    }

    public function inArea(): ?AreaInterface
    {
        return $this->inArea;
    }
}
