<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class CongregationFactory implements CongregationFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(string $name): CongregationInterface
    {
        return new Congregation($this->idGenerator->generateNew(), $name);
    }
}
