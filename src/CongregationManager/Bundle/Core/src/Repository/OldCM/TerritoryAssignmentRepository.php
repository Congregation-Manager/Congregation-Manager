<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

use Doctrine\DBAL\Connection;

final readonly class TerritoryAssignmentRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return array<array-key, array{id: string, brother_id: ?string, campaign_id: ?string, assignment_date: string, revocation_date: ?string}>
     */
    public function findAllByTerritoryId(int $territoryId): array
    {
        /* @phpstan-ignore-next-line */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('territory_assignment')
            ->where('territory_id = :territory_id')
            ->setParameter('territory_id', $territoryId)
            ->fetchAllAssociative()
        ;
    }
}
