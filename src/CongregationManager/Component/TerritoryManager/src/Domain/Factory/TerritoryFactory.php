<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Factory;

use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class TerritoryFactory implements TerritoryFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(AreaInterface $area, int $number, ?string $description = null): TerritoryInterface
    {
        return new Territory($this->idGenerator->generateNew(), $area, $number, $description);
    }
}
