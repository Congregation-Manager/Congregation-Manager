<?php

declare(strict_types=1);

namespace CongregationManager\Application\Territory;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\AreaInterface;
use CongregationManager\Domain\Territory\Model\Territory;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;

final class CreateTerritory
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository
    ) {
    }

    public function create(
        CongregationInterface $congregation,
        AreaInterface $area,
        string $name,
        ?string $description
    ): TerritoryInterface {
        $territory = new Territory($congregation, $area, $name, $description);
        $this->territoryRepository->add($territory);

        return $territory;
    }
}
