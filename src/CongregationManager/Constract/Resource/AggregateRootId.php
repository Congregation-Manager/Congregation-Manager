<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use Stringable;

abstract class AggregateRootId implements Stringable
{
    abstract public function __toString(): string;

    abstract public function equals(self $otherId): bool;
}
