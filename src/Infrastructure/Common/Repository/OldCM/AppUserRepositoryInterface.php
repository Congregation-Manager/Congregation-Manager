<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

interface AppUserRepositoryInterface
{
    /**
     * @return array<array-key, array{id: string, username: string, email: string, password: string}>
     */
    public function findOneByBrother(int $brotherId): array;
}
