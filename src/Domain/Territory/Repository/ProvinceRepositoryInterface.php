<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository;

use CongregationManager\Domain\Territory\Model\ProvinceInterface;

interface ProvinceRepositoryInterface
{
    /**
     * @return ProvinceInterface[]
     */
    public function findAll();

    /**
     * @return ProvinceInterface|null
     */
    public function find(int $id);

    public function add(ProvinceInterface $province): void;
}
