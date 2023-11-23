<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;

interface BrotherFactoryInterface
{
    public function createNew(string $name): BrotherInterface;
}
