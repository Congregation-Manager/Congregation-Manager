<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

final class CreateTerritoryAssignment
{
    public function __construct(
        private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository
    ) {
    }

    public function create(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?BrotherInterface $brother = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        $territoryAssignment = new TerritoryAssignment($territory, $assignmentDate, $brother, $revocationDate);
        $this->territoryAssignmentRepository->add($territoryAssignment);

        return $territoryAssignment;
    }
}
