<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Common\Context;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;

interface CongregationContextInterface
{
    public function getCongregation(): CongregationInterface;
}
