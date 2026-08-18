<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface as BaseCongregationInterface;
use CongregationManager\Component\Congregation\Domain\Factory\CongregationFactoryInterface;
use CongregationManager\Component\Core\Domain\Congregation;

final class CongregationFactory implements CongregationFactoryInterface
{
    #[\Override]
    public function createNew(string $name): BaseCongregationInterface
    {
        return new Congregation($name);
    }
}
