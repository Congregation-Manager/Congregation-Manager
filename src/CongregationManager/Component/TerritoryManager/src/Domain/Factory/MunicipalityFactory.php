<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class MunicipalityFactory implements MunicipalityFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(
        ProvinceInterface $province,
        string $name,
        ?string $description = null,
    ): MunicipalityInterface {
        return new Municipality($this->idGenerator->generateNew(), $province, $name, $description);
    }
}
