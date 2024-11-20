<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Contract\Resource\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Congregation extends AggregateRoot implements CongregationInterface
{
    /**
     * @var Collection<array-key, BrotherInterface>
     */
    protected Collection $brothers;

    public function __construct(
        protected string $name
    ) {
        $this->brothers = new ArrayCollection();
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
}
