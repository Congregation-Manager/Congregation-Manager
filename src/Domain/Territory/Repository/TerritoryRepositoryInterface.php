<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository;

use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryFilterResultsInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryRepositoryFilterInterface;

interface TerritoryRepositoryInterface
{
    /** @return TerritoryInterface[] */
    public function findAll();

    /** @return TerritoryInterface|null */
    public function find(int $id);

    public function add(TerritoryInterface $territory): void;

    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResultsInterface;

    public function findOneByName(string $name): ?TerritoryInterface;
}
