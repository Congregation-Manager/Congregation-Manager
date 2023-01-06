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

    /**
     * @return AreaInterface|null
     */
    public function find(int $id);

    public function add(AreaInterface $area): void;
}
