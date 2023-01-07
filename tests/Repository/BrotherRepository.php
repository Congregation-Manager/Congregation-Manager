<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

final class BrotherRepository extends InMemoryRepository implements BrotherRepositoryInterface
{
    public function add(BrotherInterface $brother): void
    {
        $this->objectCollection->add($brother);
    }

    public function getClassName(): string
    {
        return Brother::class;
    }

    public function findOneById(AggregateRootId $id): ?BrotherInterface
    {
        return $this->find($id);
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
