<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Infrastructure\Repository\InMemory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

final class CongregationRepository implements CongregationRepositoryInterface
{
    /**
     * @var CongregationInterface[]
     */
    public array $congregations = [];

    #[\Override]
    public function add(CongregationInterface $congregation): void
    {
        if (in_array($congregation, $this->congregations, true)) {
            return;
        }

        $this->congregations[] = $congregation;
    }

    #[\Override]
    public function findAll(): array
    {
        return $this->congregations;
    }

    #[\Override]
    public function findOneById(AggregateRootId $id): ?CongregationInterface
    {
        foreach ($this->congregations as $congregation) {
            if ($congregation->getId()->equals($id)) {
                return $congregation;
            }
        }

        return null;
    }
}
