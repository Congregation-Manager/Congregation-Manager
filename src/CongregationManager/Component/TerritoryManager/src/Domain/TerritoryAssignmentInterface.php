<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Contract\Resource\AggregateRootInterface;
use DateTimeInterface;

interface TerritoryAssignmentInterface extends AggregateRootInterface
{
    public function getTerritory(): TerritoryInterface;

    public function setTerritory(TerritoryInterface $territory): void;

    public function getAssignmentDate(): DateTimeInterface;

    public function setAssignmentDate(DateTimeInterface $assignmentDate): void;

    public function getRecipient(): ?RecipientInterface;

    public function setRecipient(?RecipientInterface $recipient): void;

    public function getRevocationDate(): ?DateTimeInterface;

    public function setRevocationDate(?DateTimeInterface $revocationDate): void;

    public function getExpirationDate(): ?DateTimeInterface;

    public function isGreaterThan(self $territoryAssignment): bool;

    public function hasSameDatesTo(self $territoryAssignment): bool;
}
