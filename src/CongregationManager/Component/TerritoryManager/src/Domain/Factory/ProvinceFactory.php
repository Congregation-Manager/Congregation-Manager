<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;

final class ProvinceFactory implements ProvinceFactoryInterface
{
    #[\Override]
    public function createNew(string $name, ?string $description = null): ProvinceInterface
    {
        return new Province($name, $description);
    }
}
