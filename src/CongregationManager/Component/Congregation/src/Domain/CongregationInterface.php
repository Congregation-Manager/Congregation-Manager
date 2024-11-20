<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Contract\Resource\AggregateRootInterface;
use Doctrine\Common\Collections\Collection;

interface CongregationInterface extends AggregateRootInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    /**
     * @return Collection<array-key, BrotherInterface>
     */
    public function getBrothers(): Collection;

    public function addBrother(BrotherInterface $brother): void;

    public function removeBrother(BrotherInterface $brother): void;
}
