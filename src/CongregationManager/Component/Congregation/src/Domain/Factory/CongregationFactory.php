<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;

final class CongregationFactory implements CongregationFactoryInterface
{
    #[\Override]
    public function createNew(string $name): CongregationInterface
    {
        return new Congregation($name);
    }
}
