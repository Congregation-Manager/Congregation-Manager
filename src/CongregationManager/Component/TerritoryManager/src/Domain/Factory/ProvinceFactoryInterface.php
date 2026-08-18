<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;

interface ProvinceFactoryInterface
{
    public function createNew(string $name, ?string $description = null): ProvinceInterface;
}
