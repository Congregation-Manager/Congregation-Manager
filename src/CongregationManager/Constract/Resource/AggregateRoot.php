<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

abstract class AggregateRoot implements AggregateRootInterface
{
    protected ?AggregateRootId $id = null;

    abstract public function __toString(): string;

    public function getId(): ?AggregateRootId
    {
        return $this->id;
    }
}
