<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

use Doctrine\DBAL\Connection;

final class AppUserRepository implements AppUserRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function findOneByBrother(int $brotherId): array
    {
        /* @phpstan-ignore-next-line */
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('brother_id = :brother_id')
            ->setParameter('brother_id', $brotherId)
            ->fetchAllAssociative()
        ;
    }
}
