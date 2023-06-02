<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Generator;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\S13\S13;

interface S13GeneratorInterface
{
    public function generateByCongregation(CongregationInterface $congregation, int $serviceYear): S13;
}
