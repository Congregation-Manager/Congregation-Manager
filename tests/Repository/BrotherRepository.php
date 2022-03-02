<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;

final class BrotherRepository extends InMemoryRepository implements BrotherRepositoryInterface
{
    public function add(Brother $brother): void
    {
        $this->objectCollection->add($brother);
    }

    public function getClassName(): string
    {
        return Brother::class;
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
