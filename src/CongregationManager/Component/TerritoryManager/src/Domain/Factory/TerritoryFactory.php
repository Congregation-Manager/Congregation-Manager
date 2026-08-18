<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;

final class TerritoryFactory implements TerritoryFactoryInterface
{
    #[\Override]
    public function createNew(AreaInterface $area, int $number, ?string $description = null): TerritoryInterface
    {
        return new Territory($area, $number, $description);
    }
}
