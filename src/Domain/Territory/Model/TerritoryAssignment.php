<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use DateTimeInterface;

final class TerritoryAssignment extends AggregateRoot implements TerritoryAssignmentInterface
{
    public function __construct(
        private TerritoryInterface $territory,
        private DateTimeInterface $assignmentDate,
        private ?BrotherInterface $brother = null,
        private ?DateTimeInterface $revocationDate = null
    ) {
    }

    public function getTerritory(): TerritoryInterface
    {
        return $this->territory;
    }

    public function setTerritory(TerritoryInterface $territory): void
    {
        $this->territory = $territory;
    }

    public function getAssignmentDate(): DateTimeInterface
    {
        return $this->assignmentDate;
    }

    public function setAssignmentDate(DateTimeInterface $assignmentDate): void
    {
        $this->assignmentDate = $assignmentDate;
    }

    public function getBrother(): ?BrotherInterface
    {
        return $this->brother;
    }

    public function setBrother(?BrotherInterface $brother): void
    {
        $this->brother = $brother;
    }

    public function getRevocationDate(): ?DateTimeInterface
    {
        return $this->revocationDate;
    }

    public function setRevocationDate(?DateTimeInterface $revocationDate): void
    {
        $this->revocationDate = $revocationDate;
    }
}
