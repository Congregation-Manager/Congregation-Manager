<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryFilterResultsInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use RuntimeException;

final class TerritoryRepository extends InMemoryRepository implements TerritoryRepositoryInterface
{
    public function getClassName(): string
    {
        return Territory::class;
    }

    public function add(TerritoryInterface $territory): void
    {
        $this->objectCollection->add($territory);
    }

    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResultsInterface
    {
        throw new RuntimeException('TODO');
    }

    public function findOneByNumber(int $number): ?TerritoryInterface
    {
        return $this->findOneBy([
            'number' => $number,
        ]);
    }

    public function findByCongregation(CongregationInterface $congregation): array
    {
        return $this->findBy([
            'congregation' => $congregation,
        ])->toArray();
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
