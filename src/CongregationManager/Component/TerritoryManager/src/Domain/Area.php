<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Contract\Resource\AggregateRoot;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Area extends AggregateRoot implements AreaInterface
{
    /**
     * @var Collection<array-key, TerritoryInterface>
     */
    protected Collection $territories;

    public function __construct(
        AggregateRootId $id,
        protected MunicipalityInterface $municipality,
        protected string $name,
        protected ?string $description = null
    ) {
        parent::__construct($id);
        $this->territories = new ArrayCollection();
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, $this->getName());
    }

    #[\Override]
    public function getMunicipality(): MunicipalityInterface
    {
        return $this->municipality;
    }

    #[\Override]
    public function setMunicipality(MunicipalityInterface $municipality): void
    {
        $this->municipality = $municipality;
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
     * @return Collection<array-key, TerritoryInterface>
     */
    #[\Override]
    public function getTerritories(): Collection
    {
        return $this->territories;
    }

    #[\Override]
    public function addTerritory(TerritoryInterface $territory): void
    {
        if (!$this->territories->contains($territory)) {
            $this->territories->add($territory);
        }
    }

    #[\Override]
    public function removeTerritory(TerritoryInterface $territory): void
    {
        if ($this->territories->contains($territory)) {
            $this->territories->removeElement($territory);
        }
    }
}
