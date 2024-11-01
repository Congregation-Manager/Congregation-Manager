<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;

final readonly class CreateTerritory
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository
    ) {
    }

    public function create(
        CongregationInterface $congregation,
        AreaInterface $area,
        int $name,
        ?string $description
    ): TerritoryInterface {
        $territory = new Territory($congregation, $area, $name, $description);
        $this->territoryRepository->add($territory);

        return $territory;
    }
}
