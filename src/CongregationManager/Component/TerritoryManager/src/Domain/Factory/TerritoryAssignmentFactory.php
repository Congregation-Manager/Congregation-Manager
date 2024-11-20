<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

final class TerritoryAssignmentFactory implements TerritoryAssignmentFactoryInterface
{
    #[\Override]
    public function createNew(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?RecipientInterface $recipient = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        return new TerritoryAssignment($territory, $assignmentDate, $recipient, $revocationDate);
    }
}
