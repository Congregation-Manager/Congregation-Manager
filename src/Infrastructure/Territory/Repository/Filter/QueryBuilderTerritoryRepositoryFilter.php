<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository\Filter;

use CongregationManager\Domain\Territory\Model\AreaInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryRepositoryFilterInterface;

final class QueryBuilderTerritoryRepositoryFilter implements TerritoryRepositoryFilterInterface
{
    /** @var AreaInterface[] */
    private array $areas = [];

    private ?bool $notAssigned = null;

    public function setAreas(array $areas): void
    {
        $this->areas = $areas;
    }

    public function getAreas(): array
    {
        return $this->areas;
    }

    public function setNotAssigned(?bool $notAssigned): void
    {
        $this->notAssigned = $notAssigned;
    }

    public function isNotAssigned(): ?bool
    {
        return $this->notAssigned;
    }
}
