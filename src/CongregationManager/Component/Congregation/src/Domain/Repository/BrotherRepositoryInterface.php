<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Repository;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Contract\Resource\Id;

interface BrotherRepositoryInterface
{
    /**
     * @return BrotherInterface[]
     */
    public function findAll();

    public function findOneById(Id $id): ?BrotherInterface;

    /**
     * @param array<string, string> $criteria
     * @return BrotherInterface|null
     */
    public function findOneBy(array $criteria);

    public function add(BrotherInterface $brother): void;
}
