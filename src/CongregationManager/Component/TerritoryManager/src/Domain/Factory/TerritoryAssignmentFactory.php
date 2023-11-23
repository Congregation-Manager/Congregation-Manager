<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\CongregationManager\Contract\Resource\src\IdGeneratorInterface;
use DateTimeInterface;

final readonly class TerritoryAssignmentFactory implements TerritoryAssignmentFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    public function createNew(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?BrotherInterface $brother = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        return new TerritoryAssignment(
            $this->idGenerator->generateNew(),
            $territory,
            $assignmentDate,
            $brother,
            $revocationDate
        );
    }
}
