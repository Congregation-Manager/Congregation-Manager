<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

use Doctrine\DBAL\Connection;

final readonly class AppUserRepository implements AppUserRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    #[\Override]
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
