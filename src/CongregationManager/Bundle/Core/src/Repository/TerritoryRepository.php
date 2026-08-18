<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Bundle\TerritoryManager\Repository\TerritoryRepository as BaseTerritoryRepository;
use CongregationManager\Component\Core\Domain\CongregationInterface;
use CongregationManager\Component\Core\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\Core\Domain\TerritoryInterface;

final class TerritoryRepository extends BaseTerritoryRepository implements TerritoryRepositoryInterface
{
    #[\Override]
    public function findByCongregation(CongregationInterface $congregation): array
    {
        /** @var TerritoryInterface[] $territories */
        $territories = $this->createQueryBuilder('t')
            ->andWhere('t.congregation = :congregation')
            ->setParameter('congregation', $congregation)
            ->orderBy('t.number', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $territories;
    }
}
