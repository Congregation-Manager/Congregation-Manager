<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

use Doctrine\DBAL\Connection;

final readonly class BrotherRepository implements BrotherRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    #[\Override]
    public function findAllByCongregation(int $congregationId): array
    {
        /* @phpstan-ignore-next-line */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('brothers')
            ->where('congregation_id = :congregation_id')
            ->setParameter('congregation_id', $congregationId)
            ->orderBy('surname, name', 'ASC')
            ->fetchAllAssociative()
        ;
    }
}
