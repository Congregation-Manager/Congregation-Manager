<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Congregation extends AggregateRoot implements CongregationInterface
{
    /**
     * @var Collection<array-key, BrotherInterface>
     */
    protected Collection $brothers;

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

    public function __construct(
        protected string $name
    ) {
        $this->brothers = new ArrayCollection();
        $this->provinces = new ArrayCollection();
        $this->municipalities = new ArrayCollection();
        $this->areas = new ArrayCollection();
        $this->territories = new ArrayCollection();
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, $this->getName());
    }

    #[\Override]
    public function getName(): string
    {
        return $this->name;
    }

    #[\Override]
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection<array-key, BrotherInterface>
     */
    #[\Override]
    public function getBrothers(): Collection
    {
        return $this->brothers;
    }

    #[\Override]
    public function addBrother(BrotherInterface $brother): void
    {
        if (!$this->brothers->contains($brother)) {
            $this->brothers->add($brother);
        }
    }

    #[\Override]
    public function removeBrother(BrotherInterface $brother): void
    {
        if ($this->brothers->contains($brother)) {
            $this->brothers->removeElement($brother);
        }
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
