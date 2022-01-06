<?php


namespace App\Domain\Common\Model;

use App\Domain\Common\ValueObject\AggregateRootId;

abstract class AggregateRoot
{
    public function __construct(
        private AggregateRootId $id
    ) {
    }

    final public function equals(AggregateRootId $aggregateRootId): bool
    {
        return $this->id->equals($aggregateRootId);
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
