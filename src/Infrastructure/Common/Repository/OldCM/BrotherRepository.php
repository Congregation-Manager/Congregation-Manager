<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class BrotherRepository implements BrotherRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function findAllByCongregation(int $congregationId): array
    {
        /** @var array<array-key, array{id: string, name: string, surname: string, birth_date: ?string, baptism_date: ?string, congregation_id: int, group_id: int, male: string, middle_name: ?string}> $results */
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
