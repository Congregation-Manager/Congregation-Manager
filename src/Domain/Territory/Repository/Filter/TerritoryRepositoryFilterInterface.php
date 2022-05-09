<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository\Filter;

use CongregationManager\Domain\Territory\Model\AreaInterface;

interface TerritoryRepositoryFilterInterface
{
    public function byArea(?AreaInterface $area): void;

    public function inArea(): ?AreaInterface;
}
