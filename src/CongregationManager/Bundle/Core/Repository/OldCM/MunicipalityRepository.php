<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class MunicipalityRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return array<array-key, array{id: string, name: string, description: string, congregation_id: string}>
     */
    public function findAllByCongregationAndProvince(int $congregationId, int $provinceId): array
    {
        /* @phpstan-ignore-next-line */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('municipalities')
            ->where('congregation_id = :congregation_id')
            ->andWhere('province_id = :province_id')
            ->setParameter('congregation_id', $congregationId)
            ->setParameter('province_id', $provinceId)
            ->fetchAllAssociative()
        ;
    }
}
