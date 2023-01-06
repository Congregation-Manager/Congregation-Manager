<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;

interface MunicipalityRepositoryInterface
{
    /**
     * @return MunicipalityInterface[]
     */
    public function findAll();

    /**
     * @return MunicipalityInterface|null
     */
    public function find(int $id);

    public function add(MunicipalityInterface $municipality): void;
}
