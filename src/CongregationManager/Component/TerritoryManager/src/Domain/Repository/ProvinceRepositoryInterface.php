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

    public function findOneById(int $id): ?ProvinceInterface;

    public function add(ProvinceInterface $province): void;
}
