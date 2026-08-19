<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\Congregation as BaseCongregation;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Congregation extends BaseCongregation implements CongregationInterface
{
    /**
     * @var Collection<array-key, ProvinceInterface>
     */
    protected Collection $provinces;

    /**
     * @var Collection<array-key, MunicipalityInterface>
     */
    protected Collection $municipalities;

    /**
     * @var Collection<array-key, AreaInterface>
     */
    protected Collection $areas;

    /**
     * @var Collection<array-key, TerritoryInterface>
     */
    protected Collection $territories;

    public function __construct(AggregateRootId $id, string $name)
    {
        parent::__construct($id, $name);
        $this->provinces = new ArrayCollection();
        $this->municipalities = new ArrayCollection();
        $this->areas = new ArrayCollection();
        $this->territories = new ArrayCollection();
    }

    /**
     * @return Collection<array-key, ProvinceInterface>
     */
    #[\Override]
    public function getProvinces(): Collection
    {
        return $this->provinces;
    }

    #[\Override]
    public function addProvince(ProvinceInterface $province): void
    {
        if (!$this->provinces->contains($province)) {
            $this->provinces->add($province);
        }
    }

    #[\Override]
    public function removeProvince(ProvinceInterface $province): void
    {
        if ($this->provinces->contains($province)) {
            $this->provinces->removeElement($province);
        }
    }

    /**
     * @return Collection<array-key, MunicipalityInterface>
     */
    #[\Override]
    public function getMunicipalities(): Collection
    {
        return $this->municipalities;
    }

    /**
     * @return Collection<array-key, AreaInterface>
     */
    #[\Override]
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    /**
     * @return Collection<array-key, TerritoryInterface>
     */
    #[\Override]
    public function getTerritories(): Collection
    {
        return $this->territories;
    }
}
