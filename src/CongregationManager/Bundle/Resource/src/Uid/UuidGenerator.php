<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Uid;

use CongregationManager\Contract\Resource\AggregateRootId;
use CongregationManager\Contract\Resource\IdGeneratorInterface;
use Symfony\Component\Uid\Uuid;

final class UuidGenerator implements IdGeneratorInterface
{
    /**
     * Version 7 keeps the identifiers ordered by creation time, so inserts land at the
     * end of the index instead of scattering across it.
     */
    #[\Override]
    public function generateNew(): AggregateRootId
    {
        return new UuidAggregateRootId(Uuid::v7());
    }
}
