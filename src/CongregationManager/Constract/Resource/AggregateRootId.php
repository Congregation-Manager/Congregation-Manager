<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use Stringable;

abstract class AggregateRootId implements Stringable
{
    public function __construct(
        private readonly mixed $id = null
    ) {
    }

    abstract public function __toString(): string;

    public function equals(self $otherId): bool
    {
        return $this->id === $otherId->id;
    }
}
