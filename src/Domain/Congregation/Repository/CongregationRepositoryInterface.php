<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;

interface CongregationRepositoryInterface
{
    /** @return CongregationInterface[] */
    public function findAll();

    /** @return CongregationInterface|null */
    public function find(int $id);

    public function add(CongregationInterface $congregation): void;
}
