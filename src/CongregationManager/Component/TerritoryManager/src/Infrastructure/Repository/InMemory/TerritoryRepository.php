<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Infrastructure\Repository\InMemory;

use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryFilterResultsInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use RuntimeException;

final class TerritoryRepository implements TerritoryRepositoryInterface
{
    /**
     * @var TerritoryInterface[]
     */
    public array $territories = [];

    #[\Override]
    public function findAll(): array
    {
        return $this->territories;
    }

    #[\Override]
    public function findOneById(AggregateRootId $id): ?TerritoryInterface
    {
        foreach ($this->territories as $territory) {
            if ($territory->getId()->equals($id)) {
                return $territory;
            }
        }

        return null;
    }

    #[\Override]
    public function add(TerritoryInterface $territory): void
    {
        if (in_array($territory, $this->territories, true)) {
            return;
        }

        $this->territories[] = $territory;
    }

    #[\Override]
    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResultsInterface
    {
        throw new RuntimeException('Not implemented');
    }

    #[\Override]
    public function findOneByNumber(int $number): ?TerritoryInterface
    {
        foreach ($this->territories as $territory) {
            if ($territory->getNumber() === $number) {
                return $territory;
            }
        }

        return null;
    }
}
