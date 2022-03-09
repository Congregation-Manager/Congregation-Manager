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

    public function add(BrotherInterface $brother): void;
}
