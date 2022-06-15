<?php

declare(strict_types=1);

namespace CongregationManager\Application\Territory;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\Province;
use CongregationManager\Domain\Territory\Model\ProvinceInterface;
use CongregationManager\Domain\Territory\Repository\ProvinceRepositoryInterface;

final class CreateProvince
{
    public function __construct(
        private ProvinceRepositoryInterface $provinceRepository
    ) {
    }

    public function create(
        CongregationInterface $congregation,
        string $name,
        ?string $description
    ): ProvinceInterface {
        $province = new Province($congregation, $name, $description);
        $this->provinceRepository->add($province);

        return $province;
    }
}
