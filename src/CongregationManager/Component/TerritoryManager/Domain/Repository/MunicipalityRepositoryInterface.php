<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Repository;

use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

interface MunicipalityRepositoryInterface
{
    /**
     * @return MunicipalityInterface[]
     */
    public function findAll();

    public function findOneById(int $id): ?MunicipalityInterface;

    public function add(MunicipalityInterface $municipality): void;
}
