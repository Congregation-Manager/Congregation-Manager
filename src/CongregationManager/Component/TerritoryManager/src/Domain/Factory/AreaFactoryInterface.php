<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;

interface AreaFactoryInterface
{
    public function createNew(
        MunicipalityInterface $municipality,
        string $name,
        ?string $description = null,
    ): AreaInterface;
}
