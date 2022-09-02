<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use ArrayIterator;
use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
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

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    public function getTerritoryAssignments(): Collection
    {
        return $this->territoryAssignments;
    }

    public function getSortedTerritoryAssignments(): Collection
    {
        if ($this->sortedTerritoryAssignments !== null) {
            return $this->sortedTerritoryAssignments;
        }
        /** @var Traversable<TerritoryAssignmentInterface>|ArrayIterator<array-key, TerritoryAssignmentInterface> $territoryAssignments */
        $territoryAssignments = $this->getTerritoryAssignments()
            ->getIterator();
        if (! $territoryAssignments instanceof ArrayIterator) {
            throw new RuntimeException(sprintf(
                'Unable to sort the assignments for Territory "%s": expected instance of "%s", get "%s".',
                (string) $this->getId(),
                ArrayIterator::class,
                get_debug_type($territoryAssignments)
            ));
        }
        $territoryAssignments->uasort(
            static function (mixed $first, mixed $second): int {
                if (! $first instanceof TerritoryAssignmentInterface || ! $second instanceof TerritoryAssignmentInterface) {
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

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if (! $this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->add($territoryAssignment);
        }
    }

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if ($this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->removeElement($territoryAssignment);
        }
    }

    public function getCurrentAssignment(): ?TerritoryAssignmentInterface
    {
        $actualAssignment = $this->getSortedTerritoryAssignments()
            ->last();

        if (! $actualAssignment instanceof TerritoryAssignmentInterface) {
            return null;
        }

        return $actualAssignment;
    }

    public function getLatestAssignment(): ?TerritoryAssignmentInterface
    {
        $latestAssignment = $this->getSortedTerritoryAssignments()
            ->filter(
                function (TerritoryAssignmentInterface $territoryAssignment) {
                    return $territoryAssignment->getRevocationDate() !== null;
                }
            )->last();

        if (! $latestAssignment instanceof TerritoryAssignmentInterface) {
            return null;
        }

        return $latestAssignment;
    }

    public function isAvailable(): bool
    {
        return $this->getCurrentAssignment() === null;
    }
}
