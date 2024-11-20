<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use ArrayIterator;
use CongregationManager\Contract\Resource\AggregateRoot;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RuntimeException;
use Traversable;

class Territory extends AggregateRoot implements TerritoryInterface
{
    /**
     * @var Collection<array-key, TerritoryAssignmentInterface>
     */
    protected Collection $territoryAssignments;

    /**
     * @var ?Collection<array-key, TerritoryAssignmentInterface>
     */
    protected ?Collection $sortedTerritoryAssignments = null;

    public function __construct(
        protected AreaInterface $area,
        protected int $number,
        protected ?string $description = null
    ) {
        $this->territoryAssignments = new ArrayCollection();
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, $this->getNumber());
    }

    #[\Override]
    public function getArea(): AreaInterface
    {
        return $this->area;
    }

    #[\Override]
    public function setArea(AreaInterface $area): void
    {
        $this->area = $area;
    }

    #[\Override]
    public function getNumber(): int
    {
        return $this->number;
    }

    #[\Override]
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    #[\Override]
    public function getDescription(): ?string
    {
        return $this->description;
    }

    #[\Override]
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    #[\Override]
    public function getTerritoryAssignments(): Collection
    {
        return $this->territoryAssignments;
    }

    #[\Override]
    public function getSortedTerritoryAssignments(): Collection
    {
        if ($this->sortedTerritoryAssignments !== null) {
            return $this->sortedTerritoryAssignments;
        }
        /** @var Traversable<TerritoryAssignmentInterface>|ArrayIterator<array-key, TerritoryAssignmentInterface> $territoryAssignments */
        $territoryAssignments = $this->getTerritoryAssignments()
            ->getIterator();
        if (!$territoryAssignments instanceof ArrayIterator) {
            throw new RuntimeException(sprintf(
                'Unable to sort the assignments for Territory "%s": expected instance of "%s", get "%s".',
                (string) $this->getId(),
                ArrayIterator::class,
                get_debug_type($territoryAssignments)
            ));
        }
        $territoryAssignments->uasort(
            static function (mixed $first, mixed $second): int {
                if (!$first instanceof TerritoryAssignmentInterface || !$second instanceof TerritoryAssignmentInterface) {
                    throw new RuntimeException(sprintf(
                        'Expected two implementation of territory assignments, got %s and %s',
                        get_debug_type($first),
                        get_debug_type($second)
                    ));
                }
                if ($first->hasSameDatesTo($second)) {
                    return 0;
                }

                return $first->isGreaterThan($second) ? 1 : -1;
            }
        );

        /** @var Collection<array-key, TerritoryAssignmentInterface> $sortedTerritoryAssignments */
        $sortedTerritoryAssignments = new ArrayCollection(iterator_to_array($territoryAssignments));
        $this->sortedTerritoryAssignments = $sortedTerritoryAssignments;

        return $sortedTerritoryAssignments;
    }

    #[\Override]
    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if (!$this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->add($territoryAssignment);
        }
    }

    #[\Override]
    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if ($this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->removeElement($territoryAssignment);
        }
    }

    #[\Override]
    public function getCurrentAssignment(): ?TerritoryAssignmentInterface
    {
        $actualAssignment = $this->getSortedTerritoryAssignments()
            ->last();

        if (!$actualAssignment instanceof TerritoryAssignmentInterface) {
            return null;
        }

        return $actualAssignment;
    }

    #[\Override]
    public function getLatestAssignment(): ?TerritoryAssignmentInterface
    {
        $latestAssignment = $this->getSortedTerritoryAssignments()
            ->filter(
                fn (TerritoryAssignmentInterface $territoryAssignment) => $territoryAssignment->getRevocationDate() !== null
            )->last();

        if (!$latestAssignment instanceof TerritoryAssignmentInterface) {
            return null;
        }

        return $latestAssignment;
    }

    #[\Override]
    public function hasAssignmentBetweenDates(
        DateTimeInterface $assignmentDate,
        ?DateTimeInterface $revocationDate = null,
        ?TerritoryAssignmentInterface $assignmentToSkip = null,
    ): bool {
        foreach ($this->getTerritoryAssignments() as $existingAssignment) {
            if ($existingAssignment === $assignmentToSkip) {
                continue;
            }
            if ($revocationDate === null && $existingAssignment->getRevocationDate() === null) {
                return true;
            }
            if ($revocationDate === null && $assignmentDate <= $existingAssignment->getRevocationDate()) {
                return true;
            }
            if ($existingAssignment->getAssignmentDate() > $revocationDate) {
                continue;
            }
            if ($existingAssignment->getRevocationDate() === null) {
                return true;
            }
            if ($existingAssignment->getRevocationDate() >= $assignmentDate) {
                return true;
            }
        }

        return false;
    }

    #[\Override]
    public function isAvailable(): bool
    {
        return $this->getCurrentAssignment() === null;
    }
}
