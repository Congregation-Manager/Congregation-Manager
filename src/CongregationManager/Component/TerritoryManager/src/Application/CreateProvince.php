<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Application;

use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\ProvinceRepositoryInterface;

final readonly class CreateProvince
{
    public function __construct(
        private ProvinceRepositoryInterface $provinceRepository
    ) {
    }

    public function create(string $name, ?string $description): ProvinceInterface
    {
        $province = new Province($name, $description);
        $this->provinceRepository->add($province);

        return $province;
    }
}
