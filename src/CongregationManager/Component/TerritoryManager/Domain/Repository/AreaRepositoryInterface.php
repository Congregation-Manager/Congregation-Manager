<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

interface AreaRepositoryInterface
{
    /**
     * @return AreaInterface[]
     */
    public function findAll();

    public function findOneById(AggregateRootId $id): ?AreaInterface;

    public function add(AreaInterface $area): void;
}
