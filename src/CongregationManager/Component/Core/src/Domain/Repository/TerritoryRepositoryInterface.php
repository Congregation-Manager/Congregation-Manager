<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Repository;

use CongregationManager\Component\Core\Domain\CongregationInterface;
use CongregationManager\Component\Core\Domain\TerritoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface as BaseTerritoryRepositoryInterface;

interface TerritoryRepositoryInterface extends BaseTerritoryRepositoryInterface
{
    /**
     * @return TerritoryInterface[]
     */
    public function findByCongregation(CongregationInterface $congregation): array;
}
