<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository\Filter;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;

final class QueryBuilderTerritoryRepositoryFilter implements TerritoryRepositoryFilterInterface
{
    /**
     * @var AreaInterface[]
     */
    private array $areas = [];

    private ?bool $notAssigned = null;

    private ?BrotherInterface $assignedTo = null;

    public function setAreas(array $areas): void
    {
        $this->areas = $areas;
    }

    public function getAreas(): array
    {
        return $this->areas;
    }

    public function setNotAssigned(?bool $notAssigned): void
    {
        $this->notAssigned = $notAssigned;
    }

    public function isNotAssigned(): ?bool
    {
        return $this->notAssigned;
    }

    public function getAssignedTo(): ?BrotherInterface
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(?BrotherInterface $assignedTo): void
    {
        $this->assignedTo = $assignedTo;
    }
}
