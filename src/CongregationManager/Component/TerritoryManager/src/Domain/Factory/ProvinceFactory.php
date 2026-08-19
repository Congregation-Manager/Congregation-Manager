<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class ProvinceFactory implements ProvinceFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(string $name, ?string $description = null): ProvinceInterface
    {
        return new Province($this->idGenerator->generateNew(), $name, $description);
    }
}
