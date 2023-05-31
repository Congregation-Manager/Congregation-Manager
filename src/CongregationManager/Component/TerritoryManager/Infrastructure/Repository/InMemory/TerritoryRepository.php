<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Infrastructure\Repository\InMemory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryFilterResultsInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use RuntimeException;

final class TerritoryRepository implements TerritoryRepositoryInterface
{
    /**
     * @var TerritoryInterface[]
     */
    public array $territories = [];

    public function findAll(): array
    {
        return $this->territories;
    }

    public function findOneById(int $id): ?TerritoryInterface
    {
        foreach ($this->territories as $territory) {
            if ($territory->getId() === $id) {
                return $territory;
            }
        }

        return null;
    }

    public function add(TerritoryInterface $territory): void
    {
        if (in_array($territory, $this->territories, true)) {
            return;
        }

        $this->territories[] = $territory;
    }

    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResultsInterface
    {
        throw new RuntimeException('Not implemented');
    }

    public function findOneByNumber(int $number): ?TerritoryInterface
    {
        foreach ($this->territories as $territory) {
            if ($territory->getNumber() === $number) {
                return $territory;
            }
        }

        return null;
    }

    public function findByCongregation(CongregationInterface $congregation): array
    {
        $territories = [];
        foreach ($this->territories as $territory) {
            if ($territory->getCongregation() === $congregation) {
                $territories[] = $territory;
            }
        }

        return $territories;
    }
}
