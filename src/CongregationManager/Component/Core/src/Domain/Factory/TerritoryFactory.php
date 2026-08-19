<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\Context\CongregationContextInterface;
use CongregationManager\Component\Core\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Factory\TerritoryFactoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface as BaseTerritoryInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class TerritoryFactory implements TerritoryFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
        private CongregationContextInterface $congregationContext
    ) {
    }

    #[\Override]
    public function createNew(
        AreaInterface $area,
        int $number,
        ?string $description = null,
    ): BaseTerritoryInterface {
        return new Territory(
            $this->idGenerator->generateNew(),
            $this->congregationContext->getCongregation(),
            $area,
            $number,
            $description
        );
    }
}
