<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository\Filter;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;

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

    public function getAssignedTo(): ?RecipientInterface;

    public function setAssignedTo(?RecipientInterface $assignedTo): void;
}
