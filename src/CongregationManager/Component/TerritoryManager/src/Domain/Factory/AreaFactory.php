<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class AreaFactory implements AreaFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(
        MunicipalityInterface $municipality,
        string $name,
        ?string $description = null,
    ): AreaInterface {
        return new Area($this->idGenerator->generateNew(), $municipality, $name, $description);
    }
}
