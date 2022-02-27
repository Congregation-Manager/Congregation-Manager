<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Congregation extends AggregateRoot implements CongregationInterface
{
    protected Collection $brothers;

    public function __construct(
        protected string $name
    ) {
        $this->brothers = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

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
}
