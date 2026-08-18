<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\TerritoryManager\Domain\Factory\ProvinceFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\ProvinceRepositoryInterface;

final readonly class CreateProvince
{
    public function __construct(
        private ProvinceFactoryInterface $provinceFactory,
        private ProvinceRepositoryInterface $provinceRepository
    ) {
    }

    public function create(string $name, ?string $description): ProvinceInterface
    {
        $province = $this->provinceFactory->createNew($name, $description);
        $this->provinceRepository->add($province);

        return $province;
    }
}
