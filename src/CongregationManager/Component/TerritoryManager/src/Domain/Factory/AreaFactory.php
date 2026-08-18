<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;

final class AreaFactory implements AreaFactoryInterface
{
    #[\Override]
    public function createNew(
        MunicipalityInterface $municipality,
        string $name,
        ?string $description = null,
    ): AreaInterface {
        return new Area($municipality, $name, $description);
    }
}
