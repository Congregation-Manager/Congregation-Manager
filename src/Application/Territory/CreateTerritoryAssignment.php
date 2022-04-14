<?php

declare(strict_types=1);

namespace CongregationManager\Application\Territory;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryAssignmentRepositoryInterface;
use DateTimeInterface;

final class CreateTerritoryAssignment
{
    public function __construct(private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository)
    {
    }

    public function create(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?BrotherInterface $brother = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        $territoryAssignment = new TerritoryAssignment(
            $territory,
            $assignmentDate,
            $brother,
            $revocationDate
        );
        $this->territoryAssignmentRepository->add($territoryAssignment);

        return $territoryAssignment;
    }
}
