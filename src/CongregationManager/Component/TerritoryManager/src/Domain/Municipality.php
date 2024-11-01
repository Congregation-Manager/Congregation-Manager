<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\AggregateRoot;
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

    #[\Override]
    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, $this->getName());
    }

    #[\Override]
    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    #[\Override]
    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    #[\Override]
    public function getProvince(): ProvinceInterface
    {
        return $this->province;
    }

    #[\Override]
    public function setProvince(ProvinceInterface $province): void
    {
        $this->province = $province;
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

    #[\Override]
    public function getDescription(): ?string
    {
        return $this->description;
    }

    #[\Override]
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<array-key, AreaInterface>
     */
    #[\Override]
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    #[\Override]
    public function addArea(AreaInterface $area): void
    {
        if (!$this->areas->contains($area)) {
            $this->areas->add($area);
        }
    }

    #[\Override]
    public function removeArea(AreaInterface $area): void
    {
        if ($this->areas->contains($area)) {
            $this->areas->removeElement($area);
        }
    }
}
