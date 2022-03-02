<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\Brother;

interface BrotherRepositoryInterface
{
    public function add(Brother $brother): void;
}
