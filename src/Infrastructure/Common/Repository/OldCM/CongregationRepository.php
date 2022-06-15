<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class CongregationRepository implements CongregationRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function findOneById(int $id): array
    {
        /** @var array<array-key, array{id: string, name: string}> $results */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('congregations')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAllAssociative()
        ;
    }
}
