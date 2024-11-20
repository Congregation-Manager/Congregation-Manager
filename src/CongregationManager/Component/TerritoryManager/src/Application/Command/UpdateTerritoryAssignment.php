<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application\Command;

use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

final class UpdateTerritoryAssignment
{
    public function __construct(
        private readonly TerritoryAssignmentInterface $territoryAssignment,
        private ?TerritoryInterface $territory = null,
        private ?DateTimeInterface $assignmentDate = null,
        private ?RecipientInterface $recipient = null,
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

    public function getRecipient(): ?RecipientInterface
    {
        return $this->recipient;
    }

    public function setRecipient(?RecipientInterface $recipient): void
    {
        $this->recipient = $recipient;
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
            $territoryAssignment->getRecipient(),
            $territoryAssignment->getRevocationDate()
        );
    }
}
