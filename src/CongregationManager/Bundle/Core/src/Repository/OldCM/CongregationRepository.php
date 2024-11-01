<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

use Doctrine\DBAL\Connection;

final readonly class CongregationRepository implements CongregationRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    #[\Override]
    public function findOneById(int $id): array
    {
        /* @phpstan-ignore-next-line */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('congregations')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAllAssociative()
        ;
    }
}
