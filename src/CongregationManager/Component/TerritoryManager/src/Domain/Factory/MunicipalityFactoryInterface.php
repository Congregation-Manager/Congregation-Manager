<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;

interface MunicipalityFactoryInterface
{
    public function createNew(
        ProvinceInterface $province,
        string $name,
        ?string $description = null,
    ): MunicipalityInterface;
}
