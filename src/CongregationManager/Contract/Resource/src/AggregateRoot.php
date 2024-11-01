<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

abstract class AggregateRoot implements AggregateRootInterface
{
    protected ?int $id = null;

    #[\Override]
    abstract public function __toString(): string;

    #[\Override]
    public function getId(): ?int
    {
        return $this->id;
    }

    #[\Override]
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
