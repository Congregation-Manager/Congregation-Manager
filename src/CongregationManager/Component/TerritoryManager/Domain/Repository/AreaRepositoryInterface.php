<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;

interface AreaRepositoryInterface
{
    /**
     * @return AreaInterface[]
     */
    public function findAll();

    public function findOneById(int $id): ?AreaInterface;

    public function add(AreaInterface $area): void;
}
