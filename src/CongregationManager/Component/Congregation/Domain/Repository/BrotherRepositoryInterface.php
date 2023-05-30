<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Repository;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;

interface BrotherRepositoryInterface
{
    /**
     * @return BrotherInterface[]
     */
    public function findAll();

    public function findOneById(int $id): ?BrotherInterface;

    /**
     * @return BrotherInterface|null
     * @phpstan-ignore-next-line
     */
    public function findOneBy(array $criteria);

    public function add(BrotherInterface $brother): void;
}
