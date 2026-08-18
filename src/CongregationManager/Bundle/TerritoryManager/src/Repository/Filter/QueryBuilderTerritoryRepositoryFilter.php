<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository\Filter;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;

final class QueryBuilderTerritoryRepositoryFilter implements TerritoryRepositoryFilterInterface
{
    /**
     * @var AreaInterface[]
     */
    private array $areas = [];

    private ?bool $notAssigned = null;

    private ?RecipientInterface $assignedTo = null;

    /**
     * @param array<array-key, AreaInterface> $areas
     */
    #[\Override]
    public function setAreas(array $areas): void
    {
        $this->areas = $areas;
    }

    #[\Override]
    public function getAreas(): array
    {
        return $this->areas;
    }

    #[\Override]
    public function setNotAssigned(?bool $notAssigned): void
    {
        $this->notAssigned = $notAssigned;
    }

    #[\Override]
    public function isNotAssigned(): ?bool
    {
        return $this->notAssigned;
    }

    #[\Override]
    public function getAssignedTo(): ?RecipientInterface
    {
        return $this->assignedTo;
    }

    #[\Override]
    public function setAssignedTo(?RecipientInterface $assignedTo): void
    {
        $this->assignedTo = $assignedTo;
    }
}
