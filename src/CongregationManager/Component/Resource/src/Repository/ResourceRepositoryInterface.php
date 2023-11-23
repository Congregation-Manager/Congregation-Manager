<?php

declare(strict_types=1);

namespace CongregationManager\Component\Resource\Repository;

use CongregationManager\Contract\Resource\ResourceInterface;

interface ResourceRepositoryInterface
{
    public function add(ResourceInterface $resource): void;

    public function flush(): void;
}
