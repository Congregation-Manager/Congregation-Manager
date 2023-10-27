<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

interface AggregateRootInterface extends ResourceInterface
{
    /**
     * @return list<EventInterface>
     */
    public function releaseEvents(): array;
}
