<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application\Command;

use CongregationManager\Component\TerritoryManager\Domain\Factory\TerritoryAssignmentFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;
use InvalidArgumentException;

final class CreateTerritoryAssignmentHandler
{
    public function __construct(
        private readonly TerritoryAssignmentFactoryInterface $territoryAssignmentFactory,
        private readonly TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
    ) {
    }

    public function __invoke(CreateTerritoryAssignment $command): void
    {
        $territory = $command->getTerritory();
        if (! $territory instanceof TerritoryInterface) {
            throw new InvalidArgumentException(sprintf(
                'Unable to create a new territory assignment: territory should be an instance of "%s", given "%s".',
                TerritoryInterface::class,
                get_debug_type($territory),
            ));
        }
        $assignmentDate = $command->getAssignmentDate();
        if (! $assignmentDate instanceof DateTimeInterface) {
            throw new InvalidArgumentException(sprintf(
                'Unable to create a new territory assignment: assignment date should be an instance of "%s", given "%s".',
                DateTimeInterface::class,
                get_debug_type($assignmentDate),
            ));
        }

        $territoryAssignment = $this->territoryAssignmentFactory->createNew(
            $territory,
            $assignmentDate,
            $command->getBrother(),
            $command->getRevocationDate(),
        );

        $this->territoryAssignmentRepository->add($territoryAssignment);
        $this->territoryAssignmentRepository->flush();
    }
}
