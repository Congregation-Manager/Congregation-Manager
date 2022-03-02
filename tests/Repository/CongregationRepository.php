<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\Congregation\Repository\CongregationRepositoryInterface;

final class CongregationRepository extends InMemoryRepository implements CongregationRepositoryInterface
{
    public function add(Congregation $congregation): void
    {
        $this->objectCollection->add($congregation);
    }

    public function getClassName(): string
    {
        return Congregation::class;
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
