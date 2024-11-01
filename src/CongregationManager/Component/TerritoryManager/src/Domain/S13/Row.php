<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\S13;

use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

final class Row
{
    public const int MAX_COLUMNS_ALLOWED = 4;

    private ?DateTimeInterface $lastRevocationDate = null;

    /**
     * @var Collection<int, TerritoryAssignmentInterface>
     */
    private Collection $territoryAssignments;

    public function __construct(
        private readonly TerritoryInterface $territory
    ) {
        $this->territoryAssignments = new ArrayCollection();
    }

    public function getTerritory(): TerritoryInterface
    {
        return $this->territory;
    }

    public function getLastRevocationDate(): ?DateTimeInterface
    {
        return $this->lastRevocationDate;
    }

    public function setLastRevocationDate(?DateTimeInterface $lastRevocationDate): void
    {
        $this->lastRevocationDate = $lastRevocationDate;
    }

    /**
     * @return Collection<int, TerritoryAssignmentInterface>
     */
    public function getTerritoryAssignments(): Collection
    {
        return $this->territoryAssignments;
    }

    /**
     * @param Collection<int, TerritoryAssignmentInterface> $territoryAssignments
     */
    public function setTerritoryAssignments(Collection $territoryAssignments): void
    {
        if ($territoryAssignments->count() > self::MAX_COLUMNS_ALLOWED) {
            throw new InvalidArgumentException(sprintf(
                'Columns provided are more than columns allowed. Expected max: %s, got: %s.',
                self::MAX_COLUMNS_ALLOWED,
                $territoryAssignments->count()
            ));
        }

        $this->territoryAssignments = $territoryAssignments;
    }

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if ($this->territoryAssignments->contains($territoryAssignment)) {
            return;
        }

        if ($this->territoryAssignments->count() + 1 > self::MAX_COLUMNS_ALLOWED) {
            throw new InvalidArgumentException(sprintf(
                'The max number of columns per row is %s, the row is already full.',
                self::MAX_COLUMNS_ALLOWED
            ));
        }

        $this->territoryAssignments->add($territoryAssignment);
    }

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if (!$this->territoryAssignments->contains($territoryAssignment)) {
            return;
        }

        $this->territoryAssignments->removeElement($territoryAssignment);
    }
}
