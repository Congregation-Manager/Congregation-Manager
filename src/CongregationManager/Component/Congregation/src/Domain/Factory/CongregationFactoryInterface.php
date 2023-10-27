<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;

interface CongregationFactoryInterface
{
    public function createNew(string $name): CongregationInterface;
}
