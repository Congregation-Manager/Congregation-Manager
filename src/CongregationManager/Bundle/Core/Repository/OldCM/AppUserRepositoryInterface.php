<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

interface AppUserRepositoryInterface
{
    /**
     * @return array<array-key, array{id: string, username: string, email: string, password: string}>
     */
    public function findOneByBrother(int $brotherId): array;
}
