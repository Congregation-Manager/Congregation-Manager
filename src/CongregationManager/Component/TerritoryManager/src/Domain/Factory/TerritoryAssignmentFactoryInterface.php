<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

interface TerritoryAssignmentFactoryInterface
{
    public function createNew(
        TerritoryInterface $territory,
        DateTimeInterface $assignmentDate,
        ?BrotherInterface $brother = null,
        ?DateTimeInterface $revocationDate = null,
    ): TerritoryAssignmentInterface;
}
