<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository\Filter;

use CongregationManager\Domain\Territory\Model\AreaInterface;

interface TerritoryRepositoryFilterInterface
{
    /** @return AreaInterface[] */
    public function getAreas(): array;

    /** @param AreaInterface[] $areas */
    public function setAreas(array $areas): void;

    public function isNotAssigned(): ?bool;

    public function setNotAssigned(?bool $notAssigned): void;
}
