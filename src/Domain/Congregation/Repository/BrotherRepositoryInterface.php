<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

interface BrotherRepositoryInterface
{
    /** @return BrotherInterface[] */
    public function findAll();

    /** @return BrotherInterface|null */
    public function find(int $id);

    /**
     * @return BrotherInterface|null
     * @phpstan-ignore-next-line
     */
    public function findOneBy(array $criteria);

    public function add(BrotherInterface $brother): void;
}
