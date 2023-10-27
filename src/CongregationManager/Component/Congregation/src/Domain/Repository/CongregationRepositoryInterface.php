<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Repository;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\Id;

interface CongregationRepositoryInterface
{
    /**
     * @return CongregationInterface[]
     */
    public function findAll();

    public function findOneById(Id $id): ?CongregationInterface;

    public function add(CongregationInterface $congregation): void;

    public function flush(): void;
}
