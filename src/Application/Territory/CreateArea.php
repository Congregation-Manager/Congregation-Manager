<?php

declare(strict_types=1);

namespace CongregationManager\Application\Territory;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\Area;
use CongregationManager\Domain\Territory\Model\AreaInterface;
use CongregationManager\Domain\Territory\Model\MunicipalityInterface;
use CongregationManager\Domain\Territory\Repository\AreaRepositoryInterface;

final class CreateArea
{
    public function __construct(private AreaRepositoryInterface $areaRepository)
    {
    }

    public function create(
        CongregationInterface $congregation,
        MunicipalityInterface $municipality,
        string $name,
        ?string $description
    ): AreaInterface {
        $area = new Area(
            $congregation,
            $municipality,
            $name,
            $description
        );
        $this->areaRepository->add($area);

        return $area;
    }
}
