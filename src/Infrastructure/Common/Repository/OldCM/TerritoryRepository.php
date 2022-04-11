<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class TerritoryRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /** @return array<array-key, array{id: string, name: string, description: string, congregation_id: string}> */
    public function findAllByCongregationAndArea(int $congregationId, int $areaId): array
    {
        /** @var array<array-key, array{id: string, name: string, description: string, congregation_id: string}> $results */
        $results = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('territories')
            ->where('congregation_id = :congregation_id')
            ->andWhere('area_id = :area_id')
            ->setParameter('congregation_id', $congregationId)
            ->setParameter('area_id', $areaId)
            ->fetchAllAssociative()
        ;
        return $results;
    }
}
