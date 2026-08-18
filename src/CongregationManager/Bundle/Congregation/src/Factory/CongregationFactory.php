<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Factory;

use CongregationManager\Bundle\Core\Entity\Congregation;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Factory\CongregationFactoryInterface;

final class CongregationFactory implements CongregationFactoryInterface
{
    #[\Override]
    public function createNew(string $name): CongregationInterface
    {
        return new Congregation($name);
    }
}
