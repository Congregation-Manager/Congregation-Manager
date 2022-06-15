<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRootInterface;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use Doctrine\Common\Collections\Collection;

interface TerritoryInterface extends AggregateRootInterface
{
    public function getCongregation(): CongregationInterface;

    public function setCongregation(CongregationInterface $congregation): void;

    public function getArea(): AreaInterface;

    public function setArea(AreaInterface $area): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    public function getTerritoryAssignments(): Collection;

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void;

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void;

    public function getActualAssignment(): ?TerritoryAssignmentInterface;

    public function isAvailable(): bool;

    public function getLatestAssignment(): ?TerritoryAssignmentInterface;
}
