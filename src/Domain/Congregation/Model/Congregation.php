<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Territory\Model\ProvinceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Congregation extends AggregateRoot implements CongregationInterface
{
    /** @var Collection<array-key, BrotherInterface> */
    protected Collection $brothers;

    /** @var Collection<array-key, ProvinceInterface> */
    protected Collection $provinces;

    public function __construct(
        protected string $name
    ) {
        $this->brothers = new ArrayCollection();
        $this->provinces = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @return Collection<array-key, BrotherInterface> */
    public function getBrothers(): Collection
    {
        return $this->brothers;
    }

    public function addBrother(BrotherInterface $brother): void
    {
        if (!$this->brothers->contains($brother)) {
            $this->brothers->add($brother);
        }
    }

    public function removeBrother(BrotherInterface $brother): void
    {
        if ($this->brothers->contains($brother)) {
            $this->brothers->removeElement($brother);
        }
    }

    /** @return Collection<array-key, ProvinceInterface> */
    public function getProvinces(): Collection
    {
        return $this->provinces;
    }

    public function addProvince(ProvinceInterface $province): void
    {
        if (!$this->provinces->contains($province)) {
            $this->provinces->add($province);
        }
    }

    public function removeProvince(ProvinceInterface $province): void
    {
        if ($this->provinces->contains($province)) {
            $this->provinces->removeElement($province);
        }
    }
}
