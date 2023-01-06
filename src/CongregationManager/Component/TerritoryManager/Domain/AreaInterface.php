<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\AggregateRootInterface;
use Doctrine\Common\Collections\Collection;

interface AreaInterface extends AggregateRootInterface
{
    public function getCongregation(): CongregationInterface;

    public function setCongregation(CongregationInterface $congregation): void;

    public function getMunicipality(): MunicipalityInterface;

    public function setMunicipality(MunicipalityInterface $municipality): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    /**
     * @return Collection<array-key, TerritoryInterface>
     */
    public function getTerritories(): Collection;

    public function addTerritory(TerritoryInterface $territory): void;

    public function removeTerritory(TerritoryInterface $territory): void;
}
