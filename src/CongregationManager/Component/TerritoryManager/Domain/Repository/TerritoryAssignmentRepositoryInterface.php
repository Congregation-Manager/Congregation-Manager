<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

interface TerritoryAssignmentRepositoryInterface
{
    /**
     * @return TerritoryAssignmentInterface[]
     */
    public function findAll();

    public function findOneById(int $id): ?TerritoryAssignmentInterface;

    public function add(TerritoryAssignmentInterface $territoryAssignment): void;

    public function flush(): void;
}
