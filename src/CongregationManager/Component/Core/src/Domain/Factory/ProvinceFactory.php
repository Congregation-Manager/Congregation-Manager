<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\Context\CongregationContextInterface;
use CongregationManager\Component\Core\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\Factory\ProvinceFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface as BaseProvinceInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class ProvinceFactory implements ProvinceFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
        private CongregationContextInterface $congregationContext
    ) {
    }

    #[\Override]
    public function createNew(string $name, ?string $description = null): BaseProvinceInterface
    {
        return new Province(
            $this->idGenerator->generateNew(),
            $this->congregationContext->getCongregation(),
            $name,
            $description
        );
    }
}
