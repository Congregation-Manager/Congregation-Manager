<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

abstract class AggregateRoot implements AggregateRootInterface
{
    protected ?int $id = null;

    abstract public function __toString(): string;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
