<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

interface BrotherRepositoryInterface
{
    public function add(BrotherInterface $brother): void;
}
