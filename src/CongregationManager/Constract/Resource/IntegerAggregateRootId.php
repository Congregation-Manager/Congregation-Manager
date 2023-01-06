<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

final class IntegerAggregateRootId extends AggregateRootId
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function equals(AggregateRootId $otherId): bool
    {
        if (! $otherId instanceof self) {
            return false;
        }

        return $this->id === $otherId->id;
    }
}
