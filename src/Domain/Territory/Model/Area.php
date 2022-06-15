<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Area extends AggregateRoot implements AreaInterface
{
    /**
     * @var Collection<array-key, TerritoryInterface>
     */
    protected Collection $territories;

    public function __construct(
        private CongregationInterface $congregation,
        private MunicipalityInterface $municipality,
        private string $name,
        private ?string $description = null
    ) {
        $this->territories = new ArrayCollection();
    }

    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    public function getMunicipality(): MunicipalityInterface
    {
        return $this->municipality;
    }

    public function setMunicipality(MunicipalityInterface $municipality): void
    {
        $this->municipality = $municipality;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<array-key, TerritoryInterface>
     */
    public function getTerritories(): Collection
    {
        return $this->territories;
    }

    public function addTerritory(TerritoryInterface $territory): void
    {
        if (! $this->territories->contains($territory)) {
            $this->territories->add($territory);
        }
    }

    public function removeTerritory(TerritoryInterface $territory): void
    {
        if ($this->territories->contains($territory)) {
            $this->territories->removeElement($territory);
        }
    }
}
