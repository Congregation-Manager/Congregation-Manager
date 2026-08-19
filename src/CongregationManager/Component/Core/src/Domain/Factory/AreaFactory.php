<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\Area;
use CongregationManager\Component\Core\Domain\Context\CongregationContextInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface as BaseAreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Factory\AreaFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class AreaFactory implements AreaFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
        private CongregationContextInterface $congregationContext
    ) {
    }

    #[\Override]
    public function createNew(
        MunicipalityInterface $municipality,
        string $name,
        ?string $description = null,
    ): BaseAreaInterface {
        return new Area(
            $this->idGenerator->generateNew(),
            $this->congregationContext->getCongregation(),
            $municipality,
            $name,
            $description
        );
    }
}
