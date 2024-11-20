<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\MunicipalityRepositoryInterface;

final readonly class CreateMunicipality
{
    public function __construct(
        private MunicipalityRepositoryInterface $municipalityRepository
    ) {
    }

    public function create(
        ProvinceInterface $province,
        string $name,
        ?string $description
    ): MunicipalityInterface {
        $municipality = new Municipality($province, $name, $description);
        $this->municipalityRepository->add($municipality);

        return $municipality;
    }
}
