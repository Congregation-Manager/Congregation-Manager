<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryFilterResultsInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;

interface TerritoryRepositoryInterface
{
    /**
     * @return TerritoryInterface[]
     */
    public function findAll();

    public function findOneById(int $id): ?TerritoryInterface;

    public function add(TerritoryInterface $territory): void;

    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResultsInterface;

    public function findOneByNumber(int $number): ?TerritoryInterface;

    /**
     * @return TerritoryInterface[]
     */
    public function findByCongregation(CongregationInterface $congregation): array;
}
