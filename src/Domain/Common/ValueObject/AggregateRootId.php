<?php


namespace App\Domain\Common\ValueObject;

abstract class AggregateRootId
{
    public function __construct(
        private ?int $id = null
    ) {
    }

    public function equals(AggregateRootId $aggregateRootId): bool
    {
        return $this->id === $aggregateRootId->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
