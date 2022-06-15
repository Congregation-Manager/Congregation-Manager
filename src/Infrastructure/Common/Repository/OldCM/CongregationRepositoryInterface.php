<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Repository\OldCM;

interface CongregationRepositoryInterface
{
    /**
     * @return array<array-key, array{id: string, name: string}>
     */
    public function findOneById(int $id): array;
}
