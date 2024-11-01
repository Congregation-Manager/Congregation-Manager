<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Infrastructure\Repository\InMemory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use RuntimeException;

final class BrotherRepository implements BrotherRepositoryInterface
{
    /**
     * @var BrotherInterface[]
     */
    public array $brothers = [];

    #[\Override]
    public function add(BrotherInterface $brother): void
    {
        if (in_array($brother, $this->brothers, true)) {
            return;
        }

        $this->brothers[] = $brother;
    }

    #[\Override]
    public function findAll(): array
    {
        return $this->brothers;
    }

    #[\Override]
    public function findOneById(int $id): ?BrotherInterface
    {
        foreach ($this->brothers as $brother) {
            if ($brother->getId() === $id) {
                return $brother;
            }
        }

        return null;
    }

    #[\Override]
    public function findOneBy(array $criteria): never
    {
        throw new RuntimeException('Not implemented');
    }
}
