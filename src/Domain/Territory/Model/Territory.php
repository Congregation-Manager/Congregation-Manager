<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Territory extends AggregateRoot implements TerritoryInterface
{
    /** @var Collection<array-key, TerritoryAssignmentInterface> */
    protected Collection $territoryAssignments;

    public function __construct(
        private CongregationInterface $congregation,
        private AreaInterface $area,
        private string $name,
        private ?string $description = null
    ) {
        $this->territoryAssignments = new ArrayCollection();
    }

    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    public function getArea(): AreaInterface
    {
        return $this->area;
    }

    public function setArea(AreaInterface $area): void
    {
        $this->area = $area;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /** @return Collection<array-key, TerritoryAssignmentInterface> */
    public function getTerritoryAssignments(): Collection
    {
        return $this->territoryAssignments;
    }

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if (!$this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->add($territoryAssignment);
        }
    }

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if ($this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->removeElement($territoryAssignment);
        }
    }

    public function getActualAssignment(): ?TerritoryAssignmentInterface
    {
        $actualAssignment = $this->territoryAssignments->filter(function (TerritoryAssignmentInterface $territoryAssignment) {
            return $territoryAssignment->getRevocationDate() === null;
        })->first();

        if (!$actualAssignment instanceof TerritoryAssignmentInterface) {
            return null;
        }

        return $actualAssignment;
    }

    public function getLatestAssignment(): ?TerritoryAssignmentInterface
    {
        $revocatedAssignementsIterator = $this->territoryAssignments->filter(function (TerritoryAssignmentInterface $territoryAssignment) {
            return $territoryAssignment->getRevocationDate() !== null;
        })->getIterator();
        $revocatedAssignementsIterator->uasort(function (TerritoryAssignmentInterface $first, TerritoryAssignmentInterface $second): int {
            return $first->getRevocationDate() < $second->getRevocationDate() ? 1 : -1;
        });
        $latestAssignemnt = $revocatedAssignementsIterator->current();

        if (!$latestAssignemnt instanceof TerritoryAssignmentInterface) {
            return null;
        }

        return $latestAssignemnt;
    }

    public function isAvailable(): bool
    {
        return $this->getActualAssignment() === null;
    }
}
