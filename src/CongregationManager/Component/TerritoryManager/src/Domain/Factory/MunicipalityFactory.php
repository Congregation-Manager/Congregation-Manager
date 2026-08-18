<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;

final class MunicipalityFactory implements MunicipalityFactoryInterface
{
    #[\Override]
    public function createNew(
        ProvinceInterface $province,
        string $name,
        ?string $description = null,
    ): MunicipalityInterface {
        return new Municipality($province, $name, $description);
    }
}
