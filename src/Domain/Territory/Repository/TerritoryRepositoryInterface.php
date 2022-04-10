<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository;

use CongregationManager\Domain\Territory\Model\TerritoryInterface;

interface TerritoryRepositoryInterface
{
    /** @return TerritoryInterface[] */
    public function findAll();

    /** @return TerritoryInterface|null */
    public function find(int $id);

    public function add(TerritoryInterface $territory): void;
}
