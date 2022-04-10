<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository;

use CongregationManager\Domain\Territory\Model\AreaInterface;

interface AreaRepositoryInterface
{
    /** @return AreaInterface[] */
    public function findAll();

    /** @return AreaInterface|null */
    public function find(int $id);

    public function add(AreaInterface $area): void;
}
