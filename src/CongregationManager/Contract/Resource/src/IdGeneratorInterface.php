<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

interface IdGeneratorInterface
{
    public function generateNew(): AggregateRootId;
}
