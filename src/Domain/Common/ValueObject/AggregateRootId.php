<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Common\ValueObject;

abstract class AggregateRootId
{
    public function __construct(
        private ?int $id = null
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function equals(self $aggregateRootId): bool
    {
        return $this->id === $aggregateRootId->id;
    }
}
