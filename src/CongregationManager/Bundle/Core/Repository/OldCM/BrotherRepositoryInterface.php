<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository\OldCM;

interface BrotherRepositoryInterface
{
    /**
     * @return array<array-key, array{id: string, name: string, surname: string, birth_date: ?string, baptism_date: ?string, congregation_id: int, group_id: int, male: string, middle_name: ?string}>
     */
    public function findAllByCongregation(int $congregationId): array;
}
