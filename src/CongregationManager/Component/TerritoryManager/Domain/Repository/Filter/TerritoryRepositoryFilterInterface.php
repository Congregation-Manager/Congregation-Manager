<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository\Filter;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;

interface TerritoryRepositoryFilterInterface
{
    /**
     * @return AreaInterface[]
     */
    public function getAreas(): array;

    /**
     * @param AreaInterface[] $areas
     */
    public function setAreas(array $areas): void;

    public function isNotAssigned(): ?bool;

    public function setNotAssigned(?bool $notAssigned): void;

    public function getAssignedTo(): ?BrotherInterface;

    public function setAssignedTo(?BrotherInterface $assignedTo): void;
}
