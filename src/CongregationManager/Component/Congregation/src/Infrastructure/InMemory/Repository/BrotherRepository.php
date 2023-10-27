<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Infrastructure\InMemory\Repository;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Contract\Resource\Id;
use RuntimeException;

final class BrotherRepository implements BrotherRepositoryInterface
{
    /**
     * @var BrotherInterface[]
     */
    public array $brothers = [];

    public function add(BrotherInterface $brother): void
    {
        if (in_array($brother, $this->brothers, true)) {
            return;
        }

        $this->brothers[] = $brother;
    }

    public function findAll(): array
    {
        return $this->brothers;
    }

    public function findOneById(Id $id): ?BrotherInterface
    {
        foreach ($this->brothers as $brother) {
            if ($brother->getId()->equals($id)) {
                return $brother;
            }
        }

        return null;
    }

    public function findOneBy(array $criteria)
    {
        throw new RuntimeException('Not implemented');
    }
}
