<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\AggregateRootInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;

interface TerritoryInterface extends AggregateRootInterface
{
    public function getCongregation(): CongregationInterface;

    public function setCongregation(CongregationInterface $congregation): void;

    public function getArea(): AreaInterface;

    public function setArea(AreaInterface $area): void;

    public function getNumber(): int;

    public function setNumber(int $number): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    public function getTerritoryAssignments(): Collection;

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    public function getSortedTerritoryAssignments(): Collection;

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void;

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void;

    public function getCurrentAssignment(): ?TerritoryAssignmentInterface;

    public function isAvailable(): bool;

    public function getLatestAssignment(): ?TerritoryAssignmentInterface;

    public function hasAssignmentBetweenDates(
        DateTimeInterface $assignmentDate,
        ?DateTimeInterface $revocationDate = null,
        ?TerritoryAssignmentInterface $assignmentToSkip = null,
    ): bool;
}
