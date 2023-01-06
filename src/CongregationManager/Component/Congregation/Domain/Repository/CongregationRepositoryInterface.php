<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Repository;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;

interface CongregationRepositoryInterface
{
    /**
     * @return CongregationInterface[]
     */
    public function findAll();

    /**
     * @return CongregationInterface|null
     */
    public function find(int $id);

    public function add(CongregationInterface $congregation): void;
}
