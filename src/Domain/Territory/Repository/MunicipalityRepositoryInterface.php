<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Repository;

use CongregationManager\Domain\Territory\Model\MunicipalityInterface;

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
