<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class ProvinceRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return array<array-key, array{id: string, name: string, description: string, congregation_id: string}>
     */
    public function findAllByCongregation(int $congregationId): array
    {
        /** @var array<array-key, array{id: string, name: string, description: string, congregation_id: string}> $results */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('provinces')
            ->where('congregation_id = :congregation_id')
            ->setParameter('congregation_id', $congregationId)
            ->fetchAllAssociative()
        ;
    }
}
