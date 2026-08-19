<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface as BaseCongregationInterface;
use CongregationManager\Component\Congregation\Domain\Factory\CongregationFactoryInterface;
use CongregationManager\Component\Core\Domain\Congregation;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class CongregationFactory implements CongregationFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(string $name): BaseCongregationInterface
    {
        return new Congregation($this->idGenerator->generateNew(), $name);
    }
}
