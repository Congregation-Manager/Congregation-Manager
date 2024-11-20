<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application\Command;

use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;
use InvalidArgumentException;

final readonly class UpdateTerritoryAssignmentHandler
{
    public function __construct(
        private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
    ) {
    }

    public function __invoke(UpdateTerritoryAssignment $command): void
    {
        $territory = $command->getTerritory();
        if (!$territory instanceof TerritoryInterface) {
            throw new InvalidArgumentException(sprintf(
                'Unable to update territory assignment %s: territory should be an instance of "%s", given "%s".',
                (string) $command->getTerritoryAssignment()
                    ->getId(),
                TerritoryInterface::class,
                get_debug_type($territory),
            ));
        }
        $assignmentDate = $command->getAssignmentDate();
        if (!$assignmentDate instanceof DateTimeInterface) {
            throw new InvalidArgumentException(sprintf(
                'Unable to update territory assignment %s: assignment date should be an instance of "%s", given "%s".',
                (string) $command->getTerritoryAssignment()
                    ->getId(),
                DateTimeInterface::class,
                get_debug_type($assignmentDate),
            ));
        }

        $territoryAssignment = $command->getTerritoryAssignment();
        $territoryAssignment->setTerritory($territory);
        $territoryAssignment->setAssignmentDate($assignmentDate);
        $territoryAssignment->setRecipient($command->getRecipient());
        $territoryAssignment->setRevocationDate($command->getRevocationDate());

        $this->territoryAssignmentRepository->add($territoryAssignment);
        $this->territoryAssignmentRepository->flush();
    }
}
