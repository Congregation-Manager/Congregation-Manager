<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;

final class CongregationRepository extends InMemoryRepository implements CongregationRepositoryInterface
{
    public function add(CongregationInterface $congregation): void
    {
        $this->objectCollection->add($congregation);
    }

    public function getClassName(): string
    {
        return Congregation::class;
    }

    public function findOneById(int $id): ?CongregationInterface
    {
        return $this->find($id);
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
