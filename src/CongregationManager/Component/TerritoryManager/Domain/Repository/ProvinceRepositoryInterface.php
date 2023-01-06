<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;

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
