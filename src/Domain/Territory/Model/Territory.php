<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;

class Territory extends AggregateRoot implements TerritoryInterface
{
    public function __construct(
        private CongregationInterface $congregation,
        private AreaInterface $area,
        private string $name,
        private ?string $description = null
    ) {
    }

    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    public function getArea(): AreaInterface
    {
        return $this->area;
    }

    public function setArea(AreaInterface $area): void
    {
        $this->area = $area;
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
}
