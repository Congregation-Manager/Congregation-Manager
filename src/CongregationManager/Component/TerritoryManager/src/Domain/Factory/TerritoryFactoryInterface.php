<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;

interface TerritoryFactoryInterface
{
    public function createNew(AreaInterface $area, int $number, ?string $description = null): TerritoryInterface;
}
