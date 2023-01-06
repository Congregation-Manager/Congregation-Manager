<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class AreaRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return array<array-key, array{id: string, name: string, description: string, congregation_id: string}>
     */
    public function findAllByCongregationAndMunicipality(int $congregationId, int $municipalityId): array
    {
        /* @phpstan-ignore-next-line */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('areas')
            ->where('congregation_id = :congregation_id')
            ->andWhere('municipality_id = :municipality_id')
            ->setParameter('congregation_id', $congregationId)
            ->setParameter('municipality_id', $municipalityId)
            ->fetchAllAssociative()
        ;
    }
}
