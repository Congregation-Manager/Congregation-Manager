<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\Congregation;

interface CongregationRepositoryInterface
{
    public function add(Congregation $congregation): void;
}
