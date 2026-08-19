<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Repository;

use CongregationManager\Contract\Resource\AggregateRootInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Declaring the resource type here is what gives find(), findBy() and friends their
 * return types, so the concrete repositories do not have to repeat a @method block.
 *
 * add() stays with them: the domain interfaces type it per resource, and PHP will not
 * accept a narrower parameter than the one a base class declares.
 *
 * @template T of AggregateRootInterface
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class ResourceRepository extends ServiceEntityRepository
{
    public function flush(): void
    {
        $this->getEntityManager()
->flush();
    }
}
