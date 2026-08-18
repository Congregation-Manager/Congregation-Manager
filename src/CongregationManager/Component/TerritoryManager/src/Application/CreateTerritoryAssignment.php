<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\TerritoryManager\Domain\Factory\TerritoryAssignmentFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

final readonly class CreateTerritoryAssignment
{
    public function __construct(
        private TerritoryAssignmentFactoryInterface $territoryAssignmentFactory,
        private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository
    ) {
    }

    public function create(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?RecipientInterface $recipient = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        $territoryAssignment = $this->territoryAssignmentFactory->createNew(
            $territory,
            $assignmentDate,
            $recipient,
            $revocationDate
        );
        $this->territoryAssignmentRepository->add($territoryAssignment);

        return $territoryAssignment;
    }
}
