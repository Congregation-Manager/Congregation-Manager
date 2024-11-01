<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\AreaRepositoryInterface;

final readonly class CreateArea
{
    public function __construct(
        private AreaRepositoryInterface $areaRepository
    ) {
    }

    public function create(
        CongregationInterface $congregation,
        MunicipalityInterface $municipality,
        string $name,
        ?string $description
    ): AreaInterface {
        $area = new Area($congregation, $municipality, $name, $description);
        $this->areaRepository->add($area);

        return $area;
    }
}
