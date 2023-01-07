<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Repository;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

interface BrotherRepositoryInterface
{
    /**
     * @return BrotherInterface[]
     */
    public function findAll();

    public function findOneById(AggregateRootId $id): ?BrotherInterface;

    /**
     * @return BrotherInterface|null
     * @phpstan-ignore-next-line
     */
    public function findOneBy(array $criteria);

    public function add(BrotherInterface $brother): void;
}
