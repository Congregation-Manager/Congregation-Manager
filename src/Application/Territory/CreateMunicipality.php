<?php

declare(strict_types=1);

namespace CongregationManager\Application\Territory;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\Municipality;
use CongregationManager\Domain\Territory\Model\MunicipalityInterface;
use CongregationManager\Domain\Territory\Model\ProvinceInterface;
use CongregationManager\Domain\Territory\Repository\MunicipalityRepositoryInterface;

final class CreateMunicipality
{
    public function __construct(private MunicipalityRepositoryInterface $municipalityRepository)
    {
    }

    public function create(
        CongregationInterface $congregation,
        ProvinceInterface $province,
        string $name,
        ?string $description
    ): MunicipalityInterface {
        $municipality = new Municipality(
            $congregation,
            $province,
            $name,
            $description
        );
        $this->municipalityRepository->add($municipality);

        return $municipality;
    }
}
