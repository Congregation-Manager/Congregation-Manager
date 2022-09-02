<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Generator;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\S13\S13;

interface S13GeneratorInterface
{
    public function generateByCongregation(CongregationInterface $congregation, int $theocraticYear): S13;
}
