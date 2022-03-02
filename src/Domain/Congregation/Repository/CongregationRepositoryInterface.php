<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;

interface CongregationRepositoryInterface
{
    public function add(CongregationInterface $congregation): void;
}
