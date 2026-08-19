<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\Context\CongregationContextInterface;
use CongregationManager\Component\Core\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\Factory\MunicipalityFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface as BaseMunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class MunicipalityFactory implements MunicipalityFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
        private CongregationContextInterface $congregationContext
    ) {
    }

    #[\Override]
    public function createNew(
        ProvinceInterface $province,
        string $name,
        ?string $description = null,
    ): BaseMunicipalityInterface {
        return new Municipality(
            $this->idGenerator->generateNew(),
            $this->congregationContext->getCongregation(),
            $province,
            $name,
            $description
        );
    }
}
