<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;
use DateTimeInterface;

final readonly class TerritoryAssignmentFactory implements TerritoryAssignmentFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?RecipientInterface $recipient = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        return new TerritoryAssignment(
            $this->idGenerator->generateNew(),
            $territory,
            $assignmentDate,
            $recipient,
            $revocationDate
        );
    }
}
