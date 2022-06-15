<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Province extends AggregateRoot implements ProvinceInterface
{
    /**
     * @var Collection<array-key, MunicipalityInterface>
     */
    protected Collection $municipalities;

    public function __construct(
        private CongregationInterface $congregation,
        private string $name,
        private ?string $description = null
    ) {
        $this->municipalities = new ArrayCollection();
    }

    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
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
     * @return Collection<array-key, MunicipalityInterface>
     */
    public function getMunicipalities(): Collection
    {
        return $this->municipalities;
    }

    public function addMunicipality(MunicipalityInterface $municipality): void
    {
        if (! $this->municipalities->contains($municipality)) {
            $this->municipalities->add($municipality);
        }
    }

    public function removeMunicipality(MunicipalityInterface $municipality): void
    {
        if ($this->municipalities->contains($municipality)) {
            $this->municipalities->removeElement($municipality);
        }
    }
}
