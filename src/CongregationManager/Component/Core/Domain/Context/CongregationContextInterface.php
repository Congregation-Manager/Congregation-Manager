<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Context;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;

interface CongregationContextInterface
{
    public function getCongregation(): CongregationInterface;
}
