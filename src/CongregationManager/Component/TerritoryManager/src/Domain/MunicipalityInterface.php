<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Contract\Resource\AggregateRootInterface;
use Doctrine\Common\Collections\Collection;

interface MunicipalityInterface extends AggregateRootInterface
{
    public function getProvince(): ProvinceInterface;

    public function setProvince(ProvinceInterface $province): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    /**
     * @return Collection<array-key, AreaInterface>
     */
    public function getAreas(): Collection;

    public function addArea(AreaInterface $area): void;

    public function removeArea(AreaInterface $area): void;
}
