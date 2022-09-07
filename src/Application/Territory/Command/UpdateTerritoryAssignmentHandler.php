<?php

declare(strict_types=1);

namespace CongregationManager\Application\Territory\Command;

use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryAssignmentRepositoryInterface;
use DateTimeInterface;
use InvalidArgumentException;

final class UpdateTerritoryAssignmentHandler
{
    public function __construct(
        private readonly TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
    ) {
    }

    public function __invoke(UpdateTerritoryAssignment $command): void
    {
        $territory = $command->getTerritory();
        if (! $territory instanceof TerritoryInterface) {
            throw new InvalidArgumentException(sprintf(
                'Unable to update territory assignment %s: territory should be an instance of "%s", given "%s".',
                $command->getTerritoryAssignment()
                    ->getId(),
                TerritoryInterface::class,
                get_debug_type($territory),
            ));
        }
        $assignmentDate = $command->getAssignmentDate();
        if (! $assignmentDate instanceof DateTimeInterface) {
            throw new InvalidArgumentException(sprintf(
                'Unable to update territory assignment %s: assignment date should be an instance of "%s", given "%s".',
                $command->getTerritoryAssignment()
                    ->getId(),
                DateTimeInterface::class,
                get_debug_type($assignmentDate),
            ));
        }

        $territoryAssignment = $command->getTerritoryAssignment();
        $territoryAssignment->setTerritory($territory);
        $territoryAssignment->setAssignmentDate($assignmentDate);
        $territoryAssignment->setBrother($command->getBrother());
        $territoryAssignment->setRevocationDate($command->getRevocationDate());

        $this->territoryAssignmentRepository->add($territoryAssignment);
        $this->territoryAssignmentRepository->flush();
    }
}
