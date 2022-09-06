<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\Territory;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryFilterResultsInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
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
