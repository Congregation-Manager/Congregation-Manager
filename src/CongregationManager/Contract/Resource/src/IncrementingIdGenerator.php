<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

/**
 * Hands out predictable identifiers, so tests and in-memory infrastructure can build
 * resources without pulling in a real uuid implementation.
 */
final class IncrementingIdGenerator implements IdGeneratorInterface
{
    private int $next = 1;

    #[\Override]
    public function generateNew(): AggregateRootId
    {
        return new IntegerAggregateRootId($this->next++);
    }
}
