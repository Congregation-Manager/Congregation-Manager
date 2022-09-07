<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Factory;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use DateTimeInterface;

final class TerritoryAssignmentFactory implements TerritoryAssignmentFactoryInterface
{
    public function createNew(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?BrotherInterface $brother = null,
        ?DateTimeInterface $revocationDate = null
    ): TerritoryAssignmentInterface {
        return new TerritoryAssignment($territory, $assignmentDate, $brother, $revocationDate,);
    }
}
