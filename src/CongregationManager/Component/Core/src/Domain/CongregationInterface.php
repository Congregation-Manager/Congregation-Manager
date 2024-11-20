<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface as BaseCongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use Doctrine\Common\Collections\Collection;

interface CongregationInterface extends BaseCongregationInterface
{
    /**
     * @return Collection<array-key, ProvinceInterface>
     */
    public function getProvinces(): Collection;

    public function addProvince(ProvinceInterface $province): void;

    public function removeProvince(ProvinceInterface $province): void;

    /**
     * @return Collection<array-key, MunicipalityInterface>
     */
    public function getMunicipalities(): Collection;

    /**
     * @return Collection<array-key, AreaInterface>
     */
    public function getAreas(): Collection;

    /**
     * @return Collection<array-key, TerritoryInterface>
     */
    public function getTerritories(): Collection;
}
