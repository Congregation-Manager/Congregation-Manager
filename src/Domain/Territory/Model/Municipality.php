<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Municipality extends AggregateRoot implements MunicipalityInterface
{
    /**
     * @var Collection<array-key, AreaInterface>
     */
    protected Collection $areas;

    public function __construct(
        private CongregationInterface $congregation,
        private ProvinceInterface $province,
        private string $name,
        private ?string $description = null
    ) {
        $this->areas = new ArrayCollection();
    }

    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    public function getProvince(): ProvinceInterface
    {
        return $this->province;
    }

    public function setProvince(ProvinceInterface $province): void
    {
        $this->province = $province;
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
     * @return Collection<array-key, AreaInterface>
     */
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    public function addArea(AreaInterface $area): void
    {
        if (! $this->areas->contains($area)) {
            $this->areas->add($area);
        }
    }

    public function removeArea(AreaInterface $area): void
    {
        if ($this->areas->contains($area)) {
            $this->areas->removeElement($area);
        }
    }
}
