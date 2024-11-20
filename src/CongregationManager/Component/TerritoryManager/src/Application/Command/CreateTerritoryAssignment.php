<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application\Command;

use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;

final class CreateTerritoryAssignment
{
    public function __construct(
        private ?TerritoryInterface $territory = null,
        private ?DateTimeInterface $assignmentDate = null,
        private ?RecipientInterface $recipient = null,
        private ?DateTimeInterface $revocationDate = null,
    ) {
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
}
