<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Factory\AreaFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\AreaRepositoryInterface;

final readonly class CreateArea
{
    public function __construct(
        private AreaFactoryInterface $areaFactory,
        private AreaRepositoryInterface $areaRepository
    ) {
    }

    public function create(
        MunicipalityInterface $municipality,
        string $name,
        ?string $description
    ): AreaInterface {
        $area = $this->areaFactory->createNew($municipality, $name, $description);
        $this->areaRepository->add($area);

        return $area;
    }
}
