<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Persister;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;

interface CongregationPersisterInterface
{
    public function save(CongregationInterface $congregation): void;
}
