<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Component\Congregation\Domain\Event\CongregationCreated;
use CongregationManager\Component\Congregation\Domain\Event\CongregationRenamed;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\AggregateRoot;
use CongregationManager\Contract\Resource\Exception\InvalidEventException;
use CongregationManager\Contract\Resource\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

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
        Id $id,
        protected string $name
    ) {
        parent::__construct($id);
        $this->brothers = new ArrayCollection();
        $this->provinces = new ArrayCollection();
        $this->municipalities = new ArrayCollection();
        $this->areas = new ArrayCollection();
        $this->territories = new ArrayCollection();

        $this->raise(CongregationCreated::class, [
            'name' => $name,
        ]);
    }

    public function rename(string $name): void
    {
        $this->name = $name;

        $this->raise(CongregationRenamed::class, [
            'name' => $name,
        ]);
    }

    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, $this->getName());
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<array-key, BrotherInterface>
     */
    public function getBrothers(): Collection
    {
        return $this->brothers;
    }

    public function addBrother(BrotherInterface $brother): void
    {
        if (! $this->brothers->contains($brother)) {
            $this->brothers->add($brother);
        }
    }

    public function removeBrother(BrotherInterface $brother): void
    {
        if ($this->brothers->contains($brother)) {
            $this->brothers->removeElement($brother);
        }
    }

    /**
     * @return Collection<array-key, ProvinceInterface>
     */
    public function getProvinces(): Collection
    {
        return $this->provinces;
    }

    public function addProvince(ProvinceInterface $province): void
    {
        if (! $this->provinces->contains($province)) {
            $this->provinces->add($province);
        }
    }

    public function removeProvince(ProvinceInterface $province): void
    {
        if ($this->provinces->contains($province)) {
            $this->provinces->removeElement($province);
        }
    }

    /**
     * @return Collection<array-key, MunicipalityInterface>
     */
    public function getMunicipalities(): Collection
    {
        return $this->municipalities;
    }

    /**
     * @return Collection<array-key, AreaInterface>
     */
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    /**
     * @return Collection<array-key, TerritoryInterface>
     */
    public function getTerritories(): Collection
    {
        return $this->territories;
    }
}
