<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Infrastructure\Repository\InMemory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;

final class CongregationRepository implements CongregationRepositoryInterface
{
    /**
     * @var CongregationInterface[]
     */
    public array $congregations = [];

    public function add(CongregationInterface $congregation): void
    {
        if (in_array($congregation, $this->congregations, true)) {
            return;
        }

        $this->congregations[] = $congregation;
    }

    public function findAll(): array
    {
        return $this->congregations;
    }

    public function findOneById(int $id): ?CongregationInterface
    {
        foreach ($this->congregations as $congregation) {
            if ($congregation->getId() === $id) {
                return $congregation;
            }
        }

        return null;
    }
}
