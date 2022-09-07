<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Factory;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
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
