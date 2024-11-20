<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface as BaseProvinceInterface;

interface ProvinceInterface extends BaseProvinceInterface
{
    public function getCongregation(): CongregationInterface;

    public function setCongregation(CongregationInterface $congregation): void;
}
