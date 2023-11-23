<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Repository;

use CongregationManager\Component\Resource\Repository\ResourceRepositoryInterface;
use CongregationManager\Contract\Resource\ResourceInterface;
use Doctrine\ORM\EntityRepository;

final class ResourceRepository extends EntityRepository implements ResourceRepositoryInterface
{
    public function add(ResourceInterface $resource): void
    {
    }

    public function flush(): void
    {
    }
}
