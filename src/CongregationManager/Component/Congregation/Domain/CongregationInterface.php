<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use Doctrine\Common\Collections\Collection;

interface CongregationInterface
{
    public function getId(): ?int;

    public function getName(): string;

    public function setName(string $name): void;

    /**
     * @return Collection<array-key, BrotherInterface>
     */
    public function getBrothers(): Collection;

    public function addBrother(BrotherInterface $brother): void;

    public function removeBrother(BrotherInterface $brother): void;

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
