<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application\Command;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

final class UpdateTerritoryAssignment
{
    public function __construct(
        private readonly TerritoryAssignmentInterface $territoryAssignment,
        private ?TerritoryInterface $territory = null,
        private ?DateTimeInterface $assignmentDate = null,
        private ?BrotherInterface $brother = null,
        private ?DateTimeInterface $revocationDate = null,
    ) {
    }

    public function getTerritoryAssignment(): TerritoryAssignmentInterface
    {
        return $this->territoryAssignment;
    }

    public function getTerritory(): ?TerritoryInterface
    {
        return $this->territory;
    }

    public function setTerritory(?TerritoryInterface $territory): void
    {
        $this->territory = $territory;
    }

    public function getAssignmentDate(): ?DateTimeInterface
    {
        return $this->assignmentDate;
    }

    public function setAssignmentDate(?DateTimeInterface $assignmentDate): void
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

    public static function createFromTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): self
    {
        return new self(
            $territoryAssignment,
            $territoryAssignment->getTerritory(),
            $territoryAssignment->getAssignmentDate(),
            $territoryAssignment->getBrother(),
            $territoryAssignment->getRevocationDate()
        );
    }
}
