<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository;

use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;

interface TerritoryAssignmentRepositoryInterface
{
    /**
     * @return TerritoryAssignmentInterface[]
     */
    public function findAll();

    /**
     * @return TerritoryAssignmentInterface|null
     */
    public function find(int $id);

    public function add(TerritoryAssignmentInterface $territoryAssignment): void;
}
