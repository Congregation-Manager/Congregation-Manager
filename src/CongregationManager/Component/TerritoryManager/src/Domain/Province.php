<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\AggregateRoot;
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
     * @return Collection<array-key, MunicipalityInterface>
     */
    #[\Override]
    public function getMunicipalities(): Collection
    {
        return $this->municipalities;
    }

    #[\Override]
    public function addMunicipality(MunicipalityInterface $municipality): void
    {
        if (!$this->municipalities->contains($municipality)) {
            $this->municipalities->add($municipality);
        }
    }

    #[\Override]
    public function removeMunicipality(MunicipalityInterface $municipality): void
    {
        if ($this->municipalities->contains($municipality)) {
            $this->municipalities->removeElement($municipality);
        }
    }
}
